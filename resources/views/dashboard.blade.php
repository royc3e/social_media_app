<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Toastr JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Pusher JavaScript -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(120deg, #0f0c29, #302b63, #24243e);
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: space-between; /* Creates space between the sidebar and feed */
            align-items: flex-start;
            padding: 20px; /* Creates padding around the content */
            max-width: 100px; /* Increased maximum width of the container */
            margin: 0 auto; /* Centers the container */
            max-width: calc(100% - 270px);
        }

        .sidebar {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            width: 280px;
            margin-right: 20px;
            text-align: center;
        }

        .sidebar img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
        }

        .sidebar .user-info {
            margin-top: 15px;
            text-align: center;
        }

        .sidebar .user-info h3 {
            margin: 10px 0;
        }

        .sidebar .stats {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .feed {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            width: 800px; /* Fixed width */
            margin-right: 20px;
        }


        .post-container {
            position: relative; 
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .post-content {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .post-content img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-right: 15px;
        }

        .post-text {
            color: #fff;
        }

        .like-button {
            background-color: rgba(255, 255, 255, 0.1); /* Dark transparent background */
            color: #fff; /* White text color */
            border: none;
            padding: 8px 12px; /* Adjust padding for better appearance */
            border-radius: 30px; /* Rounded corners */
            cursor: pointer;
            display: flex; /* Flex for alignment */
            align-items: center; /* Center vertically */
            transition: background-color 0.3s; /* Smooth transition */
            font-size: 20px; /* Adjust font size */
            margin-bottom: 10px;
        }

        .like-button i {
            margin-right: 5px; /* Space between icon and text */
        }

        .like-button:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Slightly lighter background on hover */
        }

        .right-sidebar {
            top: 0; 
            right: 20px;
            width: 250px; 
            height: 100%; 
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.1); 
            padding: 20px;
            box-shadow: -2px 0 5px rgba(0,0,0,0.2); 
        }

        .right-sidebar ul {
            list-style: none; 
            padding: 0; 
        }

        .right-sidebar ul li {
            padding: 10px 15px; 
            display: flex; 
            align-items: right; 
            cursor: pointer; 
            transition: background-color 0.3s; 
        }

        .right-sidebar ul li:hover {
            background-color: rgba(255, 255, 255, 0.1); /* Light background on hover */
        }

        .right-sidebar ul li i {
            margin-right: 10px; /* Space between icon and text */
            color: #fff; /* Icon color */
        }

        .right-sidebar h3 {
            text-align: center;
        }

        .menu-divider {
            border: none; 
            border-top: 2px solid rgba(255, 255, 255, 0.3); 
            margin: 10px 0;
            display: flex; 
            align-items: right; 
        }

        .comment-box {
            padding: 10px;
            width: 95%; /* Use 100% to fill the parent container */
            height: 40px; /* Set a specific height for a medium size */
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            margin: 0 auto 10px; /* Center align with auto margin */
            color: #fff;
            font-size: 16px; /* Adjust the font size as needed */
            max-width: 600px; /* Optional: Set a maximum width */
        }

        .primary-button {
            background-color: rgba(255, 255, 255, 0.1); /* Dark transparent background */
            color: #fff; /* White text color */
            border: none;
            padding: 8px 12px; /* Adjust padding for better appearance */
            border-radius: 30px; /* Rounded corners */
            cursor: pointer;
            display: inline-flex; /* Use inline-flex for button size */
            align-items: center; /* Center content vertically */
            transition: background-color 0.3s; /* Smooth transition */
            font-size: 14px; /* Adjust font size */
        }

        .primary-button:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Slightly lighter background on hover */
        }

        .comment {
            padding: 10px;
            width: 90%; 
            height: 40px; 
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            margin: 0 auto 10px; 
            color: #fff;
            font-size: 16px; 
            max-width: 600px; 
        }

        .comment::placeholder {
            color: white; 
            opacity: 0.8; 
        }

        .comment-container {
            background-color: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            padding: 10px;
            margin-top: 10px;
        }

        .comment-box::placeholder {
            color: white; /* Change the placeholder color to white */
            opacity: 0.8; /* Slightly transparent for better visibility */
        }

        .comment-container ul {
            list-style: none;
            padding: 0;
        }

        .comment-container ul li {
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.1);
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .logout-button {
            background-color: rgba(255, 255, 255, 0.1); /* Dark transparent background */
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            float: right; 
            transition: background-color 0.3s;
            margin: 10px;
        }

        .logout-button:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Slightly lighter background on hover */
        }

        .delete-post-link {
            position: absolute; 
            top: 10px; 
            right: 10px;
            color: red; 
            text-decoration: none; 
            transition: color 0.3s; 
        }

        .delete-post-link:hover {
            color: darkred; /* Change color on hover for a darker red effect */
            text-decoration: underline; /* Add underline on hover */
        }
        
        ul {
            list-style-type: none; /* Remove default bullet points from all lists */
            padding-left: 0;
        }

        .three-dot-menu {
            position: absolute;
            top: 10px; /* Aligns the menu at the top */
            right: 10px; /* Aligns the menu to the right corner */
        }

        .three-dot-button {
            background: none;
            border: none;
            cursor: pointer;
            color: #fff;
            font-size: 20px;
        }

        .three-dot-button:hover {
            color: rgba(255, 255, 255, 0.7);
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            background-color: rgba(255, 255, 255, 0.1); /* Match the feed background */
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);  
            z-index: 1000;
        }


        .dropdown-menu.ng-show {
            display: block; 
            background-color: rgba(255, 255, 0, 0.5); 
        }

        .dropdown-item {
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            display: block;
            font-size: 16px;
        }

        .dropdown-item:hover {
            background-color: rgba(255, 0, 0, 0.2);
            color: darkred;
        }

        .ng-show {
            display: block !important;
        }

        .comment-item {
            position: relative; /* Ensure dropdown is positioned correctly */
            margin-bottom: 10px; /* Space between comments */
            padding: 10px; /* Padding for the comment */
            border-bottom: 1px solid #ccc; /* Light border for separation */
        }


        .dropdown-menu a {
            color: #fff; /* White text for dropdown items */
            text-decoration: none; /* Remove underline */
            padding: 5px 10px; /* Padding for dropdown items */
            display: block; /* Make the links block elements for better spacing */
        }

        .dropdown-menu a:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Hover effect */
            border-radius: 3px; /* Rounded corners on hover */
        }

        /* Show dropdown when the corresponding item is toggled */
        .dropdown-menu[ng-show="comment.showDropdown"] {
            display: block; /* Show the dropdown when active */
        }

        .comment-edit {
            display: flex; /* Use flexbox for layout */
            align-items: center; /* Center items vertically */
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px; /* Rounded corners */
            padding: 10px; /* Space inside the box */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
            margin-top: 10px; /* Space above the comment edit box */
        }

        .comment-edit input {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            flex: 1; /* Take the remaining space */
            border: 1px solid #ccc; /* Light border */
            border-radius: 5px; /* Match rounded corners */
            padding: 8px; /* Padding for input */
            margin-right: 10px; /* Space between input and buttons */
            font-size: 14px; /* Font size for input */
            transition: border-color 0.3s; /* Smooth border color change */
        }

        .comment-edit input:focus {
            border-color: #007bff; /* Change border color on focus */
            outline: none; /* Remove outline */
        }

        .comment-edit button {
            background-color: rgba(255, 255, 255, 0.1);
            color: white; /* Button text color */
            border: none; /* Remove border */
            border-radius: 5px; /* Match rounded corners */
            padding: 8px 12px; /* Space inside the button */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s; /* Smooth background color change */
            font-size: 14px; /* Font size for button */
        }

        .comment-edit button:hover {
            background-color: #0056b3; /* Darker color on hover */
        }

        .comment-edit button:last-child {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .comment-edit button:last-child:hover {
            background-color: #c82333; /* Darker red on hover */
        }

        .logo {
            width: 100px; /* Adjust this value as needed */
            height: auto; /* Ensures the aspect ratio is maintained */
        }

        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-icon {
            cursor: pointer;
            font-size: 18px;
            color: #888;
        }

        .close-icon:hover {
            color: #333;
        }

        .notifications-popup {
            position: absolute;
            top: 375px;
            right: 140px;
            width: 250px;
            background-color: rgba(255, 255, 255, 0.1);  
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 15px;
            z-index: 100;
        }

        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .exit-icon {
            cursor: pointer;
        }

        .notifications-popup ul {
            list-style-type: none;
            padding: 0;
            margin-top: 10px;
        }

        .notification-item {
            padding: 8px 0;
            cursor: pointer;
        }

        .notification-item:hover {
            background-color: #f5f5f5;
        }

        /* Custom style for Toastr notifications */
        .toast-info .toast-message {
            display: flex;
            align-items: center;
        }
        .toast-info .toast-message i {
            margin-right: 10px;
        }
        .toast-info .toast-message .notification-content {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

    </style>
</head>
<body>
    <header class="bg-gray-800 text-white p-4">
    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
        <a href="http://127.0.0.1:8000/dashboard">
            <img src="{{ asset('logo/ideaspark.png') }}" width="200px" alt="Logo" class="logo">
        </a>
        
    </header>

    <div class="py-12" ng-app="socialApp">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container" ng-controller="PostController">
                
                <!-- Sidebar -->
                <div class="sidebar">
                    <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-profile.png') }}" alt="Profile Picture">
                    <div class="user-info">
                        <h3>{{ Auth::user()->name }}</h3>
                        <a href="{{ route('profile.edit') }}" style="color: skyblue; text-decoration: underline;">Edit Profile</a>
                    </div>
                </div>

                <!-- Feed -->
                <div class="feed">
                    <!-- CREATE POST -->
                    <h2 class="text-center">Create a New Post:</h2>
                    <form ng-submit="createPost()" class="w-full">
                        <textarea ng-model="newPost.content" placeholder="What's on your mind?" class="comment-box"></textarea>
                        <button type="submit" class="primary-button w-full">Post</button>
                    </form>

                    <h2 class="text-center mt-10">All Posts:</h2>

                    <!-- DELETE POST -->
                    <ul class="w-full">
                        <li ng-repeat="post in posts" class="post-container">
                            <!-- Three-dot menu for the post -->
                            <div class="three-dot-menu">
                                <button class="three-dot-button" ng-click="toggleDropdown(post)">
                                    <i class="fas fa-ellipsis-v"></i> <!-- Font Awesome for three-dot icon -->
                                </button>

                                <!-- Dropdown for delete action -->
                                <div class="dropdown-menu" ng-show="post.showDropdown">
                                    <a ng-click="deletePost(post.id)" class="dropdown-item">Delete</a>
                                </div>
                            </div>

                            <!-- User Profile Picture and Post Info -->
                            <div class="post-content">
                                <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-profile.png') }}" alt="Profile Picture">
                                <div class="post-text">
                                    <strong>@{{ post.user.name }}</strong> on @{{ formatDate(post.created_at) }}<br><br>
                                    <p>@{{ post.content }}</p>
                                    <hr class="menu-divider">
                                </div>
                            </div>

                            <!-- LIKE FORM -->
                            <div class="button-container">
                                <button ng-click="post.isLiked ? unlikePost(post) : likePost(post)" class="like-button">
                                    <i ng-class="post.isLiked ? 'fas fa-heart' : 'far fa-heart'"></i>
                                    @{{ post.likes_count }}
                                </button>

                                <form ng-submit="addComment(post)" class="mt-2">
                                    <input type="text" ng-model="post.newComment" placeholder="Add a comment" class="comment">
                                    <button type="submit" class="primary-button">Comment</button>
                                </form>
                            </div>

                            <!-- ALL COMMENTS -->
                            <div class="comment-container">
                                <h4>Comments:</h4>
                                <ul>
                                    <li ng-repeat="comment in post.comments" class="comment-item">
                                        <div class="comment-content" ng-if="!comment.isEditing">
                                            <strong>@{{ comment.user.name }}</strong>: @{{ comment.comment }}
                                        </div>

                                        <!-- Edit comment input field -->
                                        <div class="comment-edit" ng-if="comment.isEditing">
                                            <input type="text" ng-model="comment.comment" placeholder="Edit your comment" />
                                            <button ng-click="saveComment(post, comment)">Save</button>
                                            <button ng-click="cancelEdit(comment)">Cancel</button>
                                        </div>

                                        <!-- Toggle button for each comment -->
                                        <div class="three-dot-menu">
                                            <button class="three-dot-button" ng-click="toggleCommentDropdown(comment)">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>

                                            <!-- Dropdown for comment actions (e.g., edit, delete) -->
                                            <div class="dropdown-menu" ng-show="comment.showDropdown">
                                                <a ng-click="editComment(comment)" class="dropdown-item" ng-if="!comment.isEditing">Edit</a>
                                                <a ng-click="deleteComment(post, comment)" class="dropdown-item">Delete</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Right Sidebar -->
                <div class="right-sidebar">
                    <h3>Menu</h3>
                    <hr class="menu-divider">
                    <ul>
                        <li>
                            <i class="fas fa-home"></i> Home
                        </li>
                        <li>
                            <i class="fas fa-users"></i> Friends
                        </li>
                        <li ng-click="toggleNotifications()" class="notifications-toggle">
                            <i class="fas fa-bell"></i> Notifications
                        </li>
                    </ul>
                    
                    <!-- Notifications Pop-up -->
                    <div class="notifications-popup" ng-show="showNotifications">
                        <div class="popup-header">
                            <h3>Notifications</h3>
                            <i class="fas fa-times close-icon" ng-click="toggleNotifications()"></i>
                        </div>
                        <hr class="menu-divider">
                        <ul>
                            <li class="notification-item" ng-repeat="notification in notifications">
                                <span ng-bind="notification.message"></span>
                                <button ng-click="markNotificationAsRead(notification.id)" ng-if="!notification.is_read">Mark as Read</button>
                                <button ng-click="deleteNotification(notification.id)">Delete</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    
    <!-- Include the external JavaScript file -->
    <script src="{{ asset('js/postController.js') }}"></script>

    <script>
        // Pusher Notification Logic
        Pusher.logToConsole = true;

        // Initialize Pusher
        var pusher = new Pusher('1f8e9b140e1a32ce0eb0', {
            cluster: 'ap1'
        });

        // Subscribe to the notification channel
        var channel = pusher.subscribe('notification');

        // Bind to the test.notification event
        channel.bind('test.notification', function(data) {
            console.log('Received data:', data);

            // Display Toastr notification with icons and inline content
            if (data && data.author && data.title) {
                toastr.info(
                    `<div class="notification-content">
                        <i class="fas fa-user"></i> <span>   ${data.author}</span>
                        <i class="fas fa-book" style="margin-left: 20px;"></i> <span>  ${data.title}</span>
                    </div>`,
                    'New Post Notification',
                    {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 0,  // Set timeOut to 0 to make it persist until closed
                        extendedTimeOut: 0,  // Ensure the notification stays open
                        positionClass: 'toast-top-right',
                        enableHtml: true
                    }
                );
            } else {
                console.error('Invalid data received:', data);
            }
        });

        // Debugging line
        pusher.connection.bind('connected', function() {
            console.log('Pusher connected');
        });
    </script>
</body>
</html>