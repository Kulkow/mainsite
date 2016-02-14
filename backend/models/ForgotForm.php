<?php
namespace backend\models;
use common\models\User;

use Yii;
use yii\base\Model;

/**
 * Forgot form
 */
class ForgotForm extends Model
{
    public $username;
    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            ['username', 'validateUsername'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUsername($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError($attribute, Yii::t('app', 'Incorrect username or email.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function forgot()
    {
        if ($this->validate()) {
            if ($this->_user) {
                if (!User::isPasswordResetTokenValid($this->_user->password_reset_token)) {
                    $this->_user->generatePasswordResetToken();
                }
                if ($this->_user->save())
                {
                    return Yii::$app->mailer->compose('passwordResetToken-text', ['user' => $this->_user])
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                        ->setTo($this->_user->email)
                        ->setSubject('Password reset for ' . Yii::$app->name)
                        ->send();
                }
            }

            return false;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::find()
                ->andWhere(['or', ['username' => $this->username],
                    ['email' => $this->username],
                    ])
                ->one();
        }
        return $this->_user;
    }
}
