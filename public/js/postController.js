angular.module('socialApp', [])
    .controller('PostController', function($scope, $http) {
        $scope.posts = [];
        $scope.newPost = {};
        $scope.notifications = []; // To hold notifications
        

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
            $http.post('/posts', { content: $scope.newPost.content })
            .then(function(response) {
                const post = response.data.post; // Backend returns the complete post with `user`
        
                // Add the new post to the top of the list
                $scope.posts.unshift(post);
        
                // Reset the newPost object to clear the input field
                $scope.newPost = {};
            }, function(error) {
                console.error('Error creating post:', error);
                alert('Error creating post. Please try again.');
            });
        };
        
        // Fetch all posts
        $scope.getPosts = function() {
            $http.get('/posts')
            .then(function(response) {
                // Initialize showDropdown for each post
                $scope.posts = response.data.map(post => {
                    post.showDropdown = false; // Initialize to false
                    post.isLiked = post.isLiked || false;   
                    return post;
                });
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

        $scope.toggleDropdown = function(post) {
            // Hide other dropdowns when opening a new one
            $scope.posts.forEach(function(p) {
                if (p !== post) {
                    p.showDropdown = false;
                }
            });
        
            // Toggle the dropdown for the current post
            post.showDropdown = !post.showDropdown;
            console.log("Dropdown toggled for post ID:", post.id);

        };

        $scope.toggleCommentDropdown = function(comment) {
            // Hide other comment dropdowns when opening a new one
            $scope.posts.forEach(function(post) {
                post.comments.forEach(function(c) {
                    if (c !== comment) {
                        c.showDropdown = false;
                    }
                });
            });
        
            // Toggle the dropdown for the current comment
            comment.showDropdown = !comment.showDropdown;
        };
        
        $scope.editComment = function(comment) {
            if (comment) {
                comment.isEditing = true; // Set isEditing to true to enable editing mode
            } else {
                console.error('Comment is undefined. Cannot set isEditing.');
            }
        };

        // Save the edited comment
        $scope.saveComment = function(post, comment) {
            $http.put('/posts/' + post.id + '/comments/' + comment.id, { comment: comment.comment })
                .then(function(response) {
                    comment.isEditing = false; // Switch off editing mode
                    alert('Comment updated successfully');
                }, function(error) {
                    alert('Error updating comment');
                });
        };
        
        $scope.cancelEdit = function(comment) {
            comment.isEditing = false; // Switch off editing mode
        };
        
        // Delete a comment
        $scope.deleteComment = function(post, comment) {
            if (confirm('Are you sure you want to delete this comment?')) {
                $http.delete('/posts/' + post.id + '/comments/' + comment.id)
                    .then(function(response) {
                         // Remove the deleted comment from the comments array
                        post.comments = post.comments.filter(function(c) {
                            return c.id !== comment.id;
                        });
                        alert('Comment deleted successfully');
                    }, function(error) {
                        alert('Error deleting comment');
                    });
            }
        };

        // Listen for clicks outside the dropdown menus
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.three-dot-menu')) {
                // Close all comment dropdowns when clicking outside
                $scope.posts.forEach(function(post) {
                    post.comments.forEach(function(c) {
                        c.showDropdown = false;
                    });
                });
                $scope.$apply(); // Trigger a digest cycle to update the view
            }
        });

        // Ensure posts and notifications are always arrays
        $scope.safeForEach = function(array, callback) {
            if (Array.isArray(array)) {
                array.forEach(callback);
            }
        };

        // Toggle notifications sidebar visibility
        $scope.toggleNotifications = function() {
            $scope.showNotifications = !$scope.showNotifications;
            if ($scope.showNotifications) {
                $scope.getUnreadNotifications(); // Fetch unread notifications when opening
            }
        };


        // Fetch unread notifications from the backend
        $scope.getUnreadNotifications = function() {
            $http.get('/notifications/unread')
                .then(function(response) {
                    $scope.notifications = response.data.notifications || [];
                }, function(error) {
                    if (error.status === 404) {
                        console.error('Notifications endpoint not found, handling gracefully.');
                    } else {
                        alert('Error fetching notifications');
                    }
                });
        };

        // Mark a notification as read
        $scope.markNotificationAsRead = function(notificationId) {
            $http.put('/notifications/' + notificationId + '/read')
                .then(function(response) {
                    const notification = $scope.notifications.find(function(n) {
                        return n.id === notificationId;
                    });
                    if (notification) {
                        notification.is_read = true;
                    }
                }, function(error) {
                    alert('Error marking notification as read');
                });
        };

        // Delete a notification
        $scope.deleteNotification = function(notificationId) {
            $http.delete('/notifications/' + notificationId)
                .then(function(response) {
                    $scope.notifications = $scope.notifications.filter(function(n) {
                        return n.id !== notificationId;
                    });
                    alert('Notification deleted successfully');
                }, function(error) {
                    alert('Error deleting notification');
                });
        };

        
            
        // Fetch posts on page load
        $scope.getPosts();
    });