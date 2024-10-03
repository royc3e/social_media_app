<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                                    <div class="flex flex-col items-center mb-8">
                                        <h2 class="text-center">Create a New Post:</h2>
                                        <br>
                                        <form ng-submit="createPost()" class="w-full max-w-3xl"> <!-- Set the same max width -->
                                            <textarea ng-model="newPost.content" placeholder="What's on your mind?" class="w-full p-4 border rounded"></textarea>
                                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Post</button>
                                        </form>
                                        <br>
                                    </div>

                                    <h2 class="text-center">All Posts:</h2>

                                    <!-- Center the Post List -->
                                    <div class="flex justify-center">
                                        <ul class="mb-8 mt-2 w-full max-w-3xl"> <!-- Set a maximum width for the list -->
                                            <li ng-repeat="post in posts" class="mb-4 p-4 bg-gray-100 rounded border border-gray-500">

                                    <!-- Delete Link -->
                                    <a ng-click="deletePost(post.id)" class="text-red-500 hover:underline float-right">
                                        Delete this post
                                    </a>

                                   <!-- User Profile Picture and Post Info -->
                                   <div class="post flex items-start"> <!-- Flex container for alignment -->
                                        <!-- Display Authenticated User's Profile Picture -->
                                         
                                        <img 
                                            src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-profile.png') }}" 
                                            alt="Profile Picture" 
                                            class="rounded-full w-12 h-12 mr-2" 
                                        />
                                        
                                        <div class="post-content">
                                            <small class="font-semibold">@{{ post.user.name }}</small>
                                            <span class="text-gray-500">on @{{ formatDate(post.created_at) }}</span><br><br><br>
                                            <p>@{{ post.content }}</p>
                                        </div>
                                    </div><br>

                                    <!-- Like Form -->
                                    <button ng-click="post.isLiked ? unlikePost(post) : likePost(post)" 
                                        class="mt-2 bg-transparent border-none p-0">
                                        <i ng-class="post.isLiked ? 'fas fa-heart fa-lg' : 'far fa-heart fa-lg'" style="color: red;"></i>
                                        
                                        @{{ post.likes_count }}
                                        <span ng-if="post.likes_count !== 1"></span>
                                    </button>
                                    <br><br>


                                    <!-- Comment List -->
                                    <form ng-submit="addComment(post)">
                                        <input type="text" ng-model="post.newComment" placeholder="Add a comment">
                                        <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Comment</button>
                                    </form><br>

                                    <ul>
                                        <h4>Comments:</h4>
                                        <li ng-repeat="comment in post.comments">
                                            <strong>@{{ comment.user.name }}</strong>: @{{ comment.comment }} <!-- Displaying commenter's name -->
                                        </li>
                                    </ul>

                                </li>
                            </ul>
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
                console.log('Fetched posts:', response.data);
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

        // Like a post
        $scope.likePost = function(post) {
            $http.post('/posts/' + post.id + '/like')
            .then(function(response) {
                post.likes_count = response.data.likes_count;
                post.isLiked = response.data.isLiked;
            }, function(error) {
                alert('Error liking post');
            });
        };

        // Unlike a post
        $scope.unlikePost = function(post) {
            $http.delete('/posts/' + post.id + '/unlike')
            .then(function(response) {
                post.likes_count = response.data.likes_count;
                post.isLiked = response.data.isLiked;
            }, function(error) {
                alert('Error unliking post');
            });
        };

        // Add a comment in a post
        $scope.addComment = function(post) {
            $http.post('/posts/' + post.id + '/comments', { comment: post.newComment })
                .then(function(response) {
                    post.comments.push(response.data.comment);
                    post.newComment = '';
                    alert(response.data.message); // Show success message
                }, function(error) {
                    console.error(error);
                    alert('Error adding comment: ' + (error.data.message || 'Something went wrong'));
                });
            };




        // Fetch posts on page load
        $scope.getPosts();
    });
</script>

</x-app-layout>
