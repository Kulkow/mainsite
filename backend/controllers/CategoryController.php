<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
//use common\models\TopicSearch;
use common\models\Tag;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;



/**
 * TopicController implements the CRUD actions for Topic model.
 */
class CategoryController extends \kartik\tree\controllers\NodeController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Topic models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$searchModel = new TopicSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index');
    }

    /**
     * Saves a node once form is submitted
     */
    public function actionSave()
    {
        static::checkValidRequest(!isset($_POST['treeNodeModify']));
        $treeNodeModify = $parentKey = $currUrl = null;
        $modelClass = 'Category';
        extract(static::getPostData());
        $module = TreeView::module();
        $keyAttr = $module->dataStructure['keyAttribute'];
        $session = Yii::$app->session;
        /**
         * @var \kartik\tree\models\Tree $node
         */
        if ($treeNodeModify) {
            $node = new $modelClass;
            $successMsg = Yii::t('kvtree', 'The node was successfully created.');
            $errorMsg = Yii::t('kvtree', 'Error while creating the node. Please try again later.');
        } else {
            $tag = explode("\\", $modelClass);
            $tag = array_pop($tag);
            $id = $_POST[$tag][$keyAttr];
            $node = $modelClass::findOne($id);
            $successMsg = Yii::t('kvtree', 'Saved the node details successfully.');
            $errorMsg = Yii::t('kvtree', 'Error while saving the node. Please try again later.');
        }
        $node->activeOrig = $node->active;
        $isNewRecord = $node->isNewRecord;
        $node->load($_POST);
        if ($treeNodeModify) {
            if ($parentKey == 'root') {
                $node->makeRoot();
            } else {
                $parent = $modelClass::findOne($parentKey);
                $node->appendTo($parent);
            }
        }
        $errors = $success = false;
        if ($node->save()) {
            // check if active status was changed
            if (!$isNewRecord && $node->activeOrig != $node->active) {
                if ($node->active) {
                    $success = $node->activateNode(false);
                    $errors = $node->nodeActivationErrors;
                } else {
                    $success = $node->removeNode(true, false); // only deactivate the node(s)
                    $errors = $node->nodeRemovalErrors;
                }
            } else {
                $success = true;
            }
            if (!empty($errors)) {
                $success = false;
                $errorMsg = "<ul style='padding:0'>\n";
                foreach ($errors as $err) {
                    $errorMsg .= "<li>" . Yii::t('kvtree', "Node # {id} - '{name}': {error}", $err) . "</li>\n";
                }
                $errorMsg .= "</ul>";
            }
        } else {
            $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $node->getFirstErrors()) . '</li></ul>';
        }
        $session->set('kvNodeId', $node->$keyAttr);
        if ($success) {
            $session->setFlash('success', $successMsg);
        } else {
            $session->setFlash('error', $errorMsg);
        }
        return $this->redirect($currUrl);
    }

    /**
     * View, create, or update a tree node via ajax
     *
     * @return string json encoded response
     */
    public function actionManage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        static::checkValidRequest();
        $parentKey = $action = null;
        $modelClass = 'Category';
        $isAdmin = $softDelete = $showFormButtons = $showIDAttribute = false;
        $currUrl = $nodeView = $formOptions = $formAction = '';
        $iconsList = $nodeAddlViews = [];
        extract(static::getPostData());
        if (!isset($id) || empty($id)) {
            $node = new $modelClass;
            $node->initDefaults();
        } else {
            $node = $modelClass::findOne($id);
        }
        $module = TreeView::module();
        $params = $module->treeStructure + $module->dataStructure + [
                'node' => $node,
                'parentKey' => $parentKey,
                'action' => $formAction,
                'formOptions' => empty($formOptions) ? [] : Json::decode($formOptions),
                'modelClass' => $modelClass,
                'currUrl' => $currUrl,
                'isAdmin' => $isAdmin,
                'iconsList' => $iconsList,
                'softDelete' => $softDelete,
                'showFormButtons' => $showFormButtons,
                'showIDAttribute' => $showIDAttribute,
                'nodeView' => $nodeView,
                'nodeAddlViews' => $nodeAddlViews
            ];
        if (!empty($module->unsetAjaxBundles)) {
            Event::on(View::className(), View::EVENT_AFTER_RENDER, function ($e) use ($module) {
                foreach ($module->unsetAjaxBundles as $bundle) {
                    unset($e->sender->assetBundles[$bundle]);
                }
            });
        }
        $callback = function () use ($nodeView, $params) {
            return $this->renderAjax($nodeView, ['params' => $params]);
        };
        return self::process(
            $callback,
            Yii::t('kvtree', 'Error while viewing the node. Please try again later.'),
            null
        );
    }

    /**
     * Remove a tree node
     */
    public function actionRemove()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        static::checkValidRequest();
        $id = null;
        $class = 'Category';
        $softDelete = false;
        extract(static::getPostData());
        $node = $class::findOne($id);
        $callback = function () use ($node, $softDelete) {
            return $node->removeNode($softDelete);
        };
        return self::process(
            $callback,
            Yii::t('kvtree', 'Error removing the node. Please try again later.'),
            Yii::t('kvtree', 'The node was removed successfully.')
        );
    }

    /**
     * Move a tree node
     */
    public function actionMove()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        static::checkValidRequest();
        $dir = null;
        $idFrom = null;
        $idTo = null;
        $class = 'Category';
        $allowNewRoots = false;
        extract(static::getPostData());
        $nodeFrom = $class::findOne($idFrom);
        $nodeTo = $class::findOne($idTo);
        $callback = function () use ($dir, $nodeFrom, $nodeTo, $allowNewRoots) {
            if (!empty($nodeFrom) && !empty($nodeTo)) {
                if ($dir == 'u') {
                    $nodeFrom->insertBefore($nodeTo);
                } elseif ($dir == 'd') {
                    $nodeFrom->insertAfter($nodeTo);
                } elseif ($dir == 'l') {
                    if ($nodeTo->isRoot() && $allowNewRoots) {
                        $nodeFrom->makeRoot();
                    } else {
                        $nodeFrom->insertAfter($nodeTo);
                    }
                } elseif ($dir == 'r') {
                    $nodeFrom->appendTo($nodeTo);
                }
                return $nodeFrom->save();
            }
            return true;
        };
        return self::process(
            $callback,
            Yii::t('kvtree', 'Error while moving the node. Please try again later.'),
            Yii::t('kvtree', 'The node was moved successfully.')
        );
    }

    /**
     * Processes a code block and catches exceptions
     *
     * @param Closure $callback   the function to execute (this returns a valid `$success`)
     * @param string  $msgError   the default error message to return
     * @param string  $msgSuccess the default success error message to return
     *
     * @return array outcome of the code consisting of following keys:
     * - 'out': string, the output content
     * - 'status': string, success or error
     */
    public static function process($callback, $msgError, $msgSuccess)
    {
        $error = $msgError;
        $success = false;
        try {
            $success = call_user_func($callback);
        } catch (\yii\db\Exception $e) {
            $error = $e->getMessage();
        } catch (\yii\base\NotSupportedException $e) {
            $error = $e->getMessage();
        } catch (\yii\base\InvalidParamException $e) {
            $error = $e->getMessage();
        } catch (\yii\base\InvalidConfigException $e) {
            $error = $e->getMessage();
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
        if ($success !== false) {
            $out = $msgSuccess === null ? $success : $msgSuccess;
            return ['out' => $out, 'status' => 'success'];
        } else {
            return ['out' => $error, 'status' => 'error'];
        }
    }
}
