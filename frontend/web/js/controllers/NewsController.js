function NewsController($scope, $http) {
    $scope.news = [];

    $scope.orderOptions = {
        field: 'created_date'
    };

    $scope.reverseOptions = {};

    $scope.getNews = function() {
        $http({
            //url: '/news/getNews',
            url: 'post/GetTopics',
            method: 'GET'
        }).success(function(data) {
            angular.forEach(data, function(newsItem) {
                newsItem.like_count = Number(newsItem.like_count);
                $scope.news.push(newsItem);
            });
        });
    }

    $scope.setOrder = function(field, reverse) {
        if ($scope.orderOptions.field != field) {
            $scope.reverseOptions[field] = reverse;
        } else {
            $scope.reverseOptions[field] = !$scope.reverseOptions[field];
        }
        $scope.orderOptions.field = field;

        return false;
    }
}