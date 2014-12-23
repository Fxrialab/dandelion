(function ($) {

    var settings = {
        nop: 5, // The number of posts per scroll to be loaded
        offset: 0, // Initial offset, begins at 0 in this case
        error: 'No More Activity!', // When the user reaches the end this is the message that is
        // displayed. You can change this if you want.
        delay: 500, // When you scroll down the posts will load after a delayed amount of time.
        // This is mainly for usability concerns. You can alter this as you see fit
        scroll: true // The main bit, if set to false posts will not load as the user scrolls. 
                // but will still load if the user clicks.
    };
    $.fn.scrollPaginationFriend = function (options) {
// Extend the options so they work with the plugin
        if (options) {
            $.extend(settings, options);
        }

// For each so that we keep chainability.
        return this.each(function () {

// Some variables 
            $this = $(this);
            $settings = settings;
            var offset = $settings.offset;
            var busy = false; // Checks if the scroll action is happening 
            var userID = $("#userID").val();
            // so we don't run it multiple times

            // Custom messages based on settings
            if ($settings.scroll == true)
                $initmessage = '<div></div>';
            else
                $initmessage = 'Click for more';
            // Append custom messages and extra UI
            $this.append('<div class="column-group"></div><div class="loading-bar">' + $initmessage + '</div>');
            function getData() {
                $.post('/loadFriend', {
                    action: 'scrollpagination',
                    number: $settings.nop,
                    offset: offset,
                    userID: userID
                }, function (data) {
                    $this.find('.loading-bar').html($initmessage);
                    if (data == "") {
                        $this.find('.loading-bar').html($settings.error);
                    }
                    else {
                        offset = offset + $settings.nop;
                        $this.find('.column-group').append(data);
                        busy = false;
                    }
                    updateTime();
                });
            }

            getData(); // Run function initially

            // If scrolling is enabled
            if ($settings.scroll == true) {
// .. and the user is scrolling
                $(window).scroll(function () {

// Check the user is at the bottom of the element
                    if ($(window).scrollTop() + $(window).height() > $this.height() && !busy) {

// Now we are working, so busy is true
                        busy = true;
                        // Tell the user we're loading posts
                        $this.find('.loading-bar').html('<div></div>');
                        // Run the function to fetch the data inside a delay
                        // This is useful if you have content in a footer you
                        // want the user to see.
                        setTimeout(function () {

                            getData();
                        }, $settings.delay);
                    }
                });
            }

// Also content can be loaded by clicking the loading bar/
            $this.find('.loading-bar').click(function () {

                if (busy == false) {
                    busy = true;
                    getData();
                }

            });
        });
    };
    $.fn.scrollPhoto = function (options) {
        if (options) {
            $.extend(settings, options);
        }
        return this.each(function () {
            $this = $(this);
            $settings = settings;
            var offset = $settings.offset;
            var busy = false; // Checks if the scroll action is happening 
            var userID = $("#userID").val();
            var albumID = $("#albumID").val();
            // Custom messages based on settings
            if ($settings.scroll == true)
                $initmessage = '<div></div>';
            else
                $initmessage = 'Click for more';
            $this.append('<div class="column-group"></div><div class="loading-bar">' + $initmessage + '</div>');
            function getData() {
                $.post('/content/photo/loading', {
                    action: 'scrollpagination',
                    number: $settings.nop,
                    offset: offset,
                    userID: userID,
                    albumID: albumID
                }, function (data) {
                    if (data == "") {
                        $this.find('.loading-bar').html('');
                    }
                    else {
                        offset = offset + $settings.nop;
                        $this.find('.column-group').append(data);
                        if (data.indexOf('noDataDisplay'))
                            busy = true;
                        else
                            busy = false;
                    }
                    updateTime();
                });
            }

            getData(); // Run function initially

            if ($settings.scroll == true) {
                $(window).scroll(function () {
                    if ($(window).scrollTop() + $(window).height() > $this.height() && !busy) {
                        busy = true;
                        $this.find('.loading-bar').html('<div></div>');
                        setTimeout(function () {
                            getData();
                        }, $settings.delay);
                    } else {
                        $this.find('.loading-bar').fadeOut('normal');
                    }
                });
            }
        });
    };
    $.fn.scrollPaginationPostMod = function (options) {
        // Extend the options so they work with the plugin
        if (options) {
            $.extend(settings, options);
        }
        // For each so that we keep chainability.
        return this.each(function () {
            // Some variables
            $this = $(this);
            $settings = settings;
            var offset = $settings.offset;
            var busy = false; // Checks if the scroll action is happening
            // so we don't run it multiple times
            // Custom messages based on settings
            if ($settings.scroll == true)
                $initmessage = '<div></div>';
            else
                $initmessage = 'Click for more';
            // Append custom messages and extra UI
            $this.append('<div class="content"></div><div class="loading-bar">' + $initmessage + '</div>');
            function getData() {

                // Post data to ajax.php
                $.post('/content/post/loading', {
                    action: 'scrollpagination',
                    number: $settings.nop,
                    offset: offset
                }, function (data) {
                    // Change loading bar content (it may have been altered)
                    $this.find('.loading-bar').html($initmessage);
                    // If there is no data returned, there are no more posts to be shown. Show error
                    if (data == "") {
                        $this.find('.loading-bar').html($settings.error);
                    }
                    else {
                        // Offset increases
                        offset = offset + $settings.nop;
                        // Append the data to the content div
                        $this.find('.content').append(data);
                        // No longer busy!	
                        busy = false;
                    }
                    updateTime();
                });
            }

            getData(); // Run function initially

            // If scrolling is enabled
            if ($settings.scroll == true) {
                // .. and the user is scrolling
                $(window).scroll(function () {

                    // Check the user is at the bottom of the element
                    if ($(window).scrollTop() + $(window).height() > $this.height() && !busy) {
                        // Now we are working, so busy is true
                        busy = true;
                        // Tell the user we're loading posts
                        $this.find('.loading-bar').html('<div></div>');
                        // Run the function to fetch the data inside a delay
                        // This is useful if you have content in a footer you
                        // want the user to see.
                        setTimeout(function () {
                            getData();
                        }, $settings.delay);
                    }
                });
            }
            // Also content can be loaded by clicking the loading bar/
            $this.find('.loading-bar').click(function () {
                if (busy == false) {
                    busy = true;
                    getData();
                }
            });
        });
    };
    $.fn.scrollPaginationHomePage = function (options) {
// Extend the options so they work with the plugin
        if (options) {
            $.extend(settings, options);
        }

// For each so that we keep chainability.
        return this.each(function () {

// Some variables 
            $this = $(this);
            $settings = settings;
            var offset = $settings.offset;
            var busy = false; // Checks if the scroll action is happening 
            var whereIs = $("#whereIs").val();
            var profileID = $("#currentProfile").val();
            var type = $("#type").val();
            var typeID = $("#typeID").val();
            // so we don't run it multiple times

            // Custom messages based on settings
            if ($settings.scroll == true)
                $initmessage = '<div></div>';
            else
                $initmessage = 'Click for more';
            // Append custom messages and extra UI
            $this.append('<div class="content"></div><div class="loading-bar">' + $initmessage + '</div>');
            function getData() {

                // Post data to ajax.php
                $.post('/loading', {
                    action: 'scrollpagination',
                    number: $settings.nop,
                    offset: offset,
                    type: whereIs,
                    profile: profileID,
                    type: type,
                            typeID: typeID
                }, function (data) {

                    // Change loading bar content (it may have been altered)
                    $this.find('.loading-bar').html($initmessage);
                    // If there is no data returned, there are no more posts to be shown. Show error
                    if (data == "") {
                        $this.find('.loading-bar').html($settings.error);
                    }
                    else {

                        // Offset increases
                        offset = offset + $settings.nop;
                        // Append the data to the content div
                        $this.find('.content').append(data);
                        // No longer busy!	
                        busy = false;
                    }
                    updateTime();
                });
            }

            getData(); // Run function initially

            // If scrolling is enabled
            if ($settings.scroll == true) {
// .. and the user is scrolling
                $(window).scroll(function () {

// Check the user is at the bottom of the element
                    if ($(window).scrollTop() + $(window).height() > $this.height() && !busy) {

// Now we are working, so busy is true
                        busy = true;
                        // Tell the user we're loading posts
                        $this.find('.loading-bar').html('<div></div>');
                        // Run the function to fetch the data inside a delay
                        // This is useful if you have content in a footer you
                        // want the user to see.
                        setTimeout(function () {

                            getData();
                        }, $settings.delay);
                    }
                });
            }

// Also content can be loaded by clicking the loading bar/
            $this.find('.loading-bar').click(function () {

                if (busy == false) {
                    busy = true;
                    getData();
                }

            });
        });
    };
    $.fn.scrollPaginationGroup = function (options) {
        if (options) {
            $.extend(settings, options);
        }
        return this.each(function () {
            $this = $(this);
            $settings = settings;
            var offset = $settings.offset;
            var roleGroup = $("#roleGroup").val();
            var busy = false;
            if ($settings.scroll == true)
                $initmessage = '<div></div>';
            else
                $initmessage = 'Click for more';
            $this.append('<div class="column-group"></div>');
            function getData() {
                $.post('/content/group/successGroup', {
                    action: 'scrollpagination',
                    number: $settings.nop,
                    offset: offset,
                    roleGroup: roleGroup
                }, function (data) {
                    if (data == "") {
                        $this.find('.loading-bar').html($initmessage);
                    } else {
                        offset = offset + $settings.nop;
                        $this.find('.column-group').append(data);
                        busy = false;
                    }
                    updateTime();
                });
            }

//            if (count < 10) {
            getData(); // Run function initially
//            }
            if ($settings.scroll == true) {
                $(window).scroll(function () {
                    if ($(window).scrollTop() + $(window).height() > $this.height() && !busy) {
                        busy = true;
                        $this.find('.loading-bar').html('<div></div>');
                        setTimeout(function () {
                            getData();
                        }, $settings.delay);
                    }
                });
            }
            $this.find('.loading-bar').click(function () {
                if (busy == false) {
                    busy = true;
                    getData();
                }

            });
        });
    };
    $.fn.scrollPaginationGroupMod = function (options) {
        // Extend the options so they work with the plugin
        if (options) {
            $.extend(settings, options);
        }
        // For each so that we keep chainability.
        return this.each(function () {
            // Some variables
            $this = $(this);
            $settings = settings;
            var offset = $settings.offset;
            var busy = false; // Checks if the scroll action is happening
            var groupID = $("#typeID").val();
            // so we don't run it multiple times
            // Custom messages based on settings
            if ($settings.scroll == true)
                $initmessage = '<div></div>';
            else
                $initmessage = 'Click for more';
            // Append custom messages and extra UI
            $this.append('<div class="content"></div><div class="loading-bar">' + $initmessage + '</div>');
            function getData() {
                // Post data to ajax.php
                $.post('/content/group/loading', {
                    action: 'scrollpagination',
                    number: $settings.nop,
                    offset: offset,
                    groupID: groupID
                }, function (data) {
                    // Change loading bar content (it may have been altered)
                    $this.find('.loading-bar').html($initmessage);
                    // If there is no data returned, there are no more posts to be shown. Show error
                    if (data == "") {
                        $this.find('.loading-bar').html($settings.error);
                    }
                    else {
                        // Offset increases
                        offset = offset + $settings.nop;
                        // Append the data to the content div
                        $this.find('.content').append(data);
                        // No longer busy!
                        busy = false;
                    }
                    updateTime();
                });
            }
            getData(); // Run function initially
            // If scrolling is enabled
            if ($settings.scroll == true) {
                // .. and the user is scrolling
                $(window).scroll(function () {
                    // Check the user is at the bottom of the element
                    if ($(window).scrollTop() + $(window).height() > $this.height() && !busy) {
                        // Now we are working, so busy is true
                        busy = true;
                        // Tell the user we're loading posts
                        $this.find('.loading-bar').html('<div></div>');
                        // Run the function to fetch the data inside a delay
                        // This is useful if you have content in a footer you
                        // want the user to see.
                        setTimeout(function () {
                            getData();
                        }, $settings.delay);
                    }
                });
            }
            // Also content can be loaded by clicking the loading bar/
            $this.find('.loading-bar').click(function () {
                if (busy == false) {
                    busy = true;
                    getData();
                }
            });
        });
    };
})(jQuery);
