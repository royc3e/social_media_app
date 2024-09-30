<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" ng-app="socialApp">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div ng-controller="PostController">
                    <!-- Post Creation Form -->
                    <h2>Create a New Post:</h2>
                    <form ng-submit="createPost()">
                        <textarea ng-model="newPost.content" placeholder="What's on your mind?" class="w-full p-2 border rounded"></textarea>
                        <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Post</button>
                    </form><br>

                    <h2>All Posts</h2>

                    <!-- Post List -->
                    <ul class=" mb-8 mt-2">
                        <li ng-repeat="post in posts" class="mb-4 p-4 bg-gray-100 rounded">
                            <p>@{{ post.content }}</p>
                            <small>By @{{ post.user.name }} on @{{ formatDate(post.created_at) }}</small><br>
                            <!-- Delete Button -->
                            <button ng-click="deletePost(post.id)" class="mt-2 px-4 py-2 bg-red-500 text-white rounded">
                                Delete
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>


<script>
    angular.module('socialApp', [])
    .controller('PostController', function($scope, $http) {
        $scope.posts = [];
        $scope.newPost = {};

        // Format date function
        $scope.formatDate = function(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }).replace(',', '');
        };

        // Create a new post
        $scope.createPost = function() {
            $http.post('/posts', $scope.newPost)
            .then(function(response) {
                $scope.posts.unshift(response.data);
                $scope.newPost = {};
            }, function(error) {
                alert('Error creating post');
            });
        };

        // Fetch all posts
        $scope.getPosts = function() {
            $http.get('/posts')
            .then(function(response) {
                $scope.posts = response.data;
            }, function(error) {
                alert('Error fetching posts');
            });
        };

            // Delete a post
        $scope.deletePost = function(postId) {
            if (confirm('Are you sure you want to delete this post?')) {
                $http.delete('/posts/' + postId)
                .then(function(response) {
                    // Remove the deleted post from the list
                    $scope.posts = $scope.posts.filter(function(post) {
                        return post.id !== postId;
                    });
                    alert('Post deleted successfully');
                }, function(error) {
                    alert('Error deleting post');
                });
            }
        };



        // Fetch posts on page load
        $scope.getPosts();
    });
</script>

</x-app-layout>
