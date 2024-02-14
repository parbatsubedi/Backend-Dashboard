<?php
$url = url()->current();
//$today = \Carbon\Carbon::now()->format('d M, Y');
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <img src="{{ asset('storage/uploads/settings/' . \DB::table('rebranding_setting')->value('logo')) }}" alt="Site Logo" class="responsive-site-logo">
                        <span class="block m-t-xs font-bold" style="text-align: center;">&nbsp; {{ auth()->user()->name }}</span>
                        <span class="text-muted text-xs block" style="text-align: center;">&nbsp;{{ auth()->user()->email }}</span>
                    </a>
                </div>
                <div class="logo-element">
                    <?php
                    $siteTitle = \DB::table('rebranding_setting')->value('site_title');
                    if(isset($siteTitle)){
                        $words = explode(' ', $siteTitle);
                        $firstLetter = ucfirst($words[0][0]);
                        $secondLetter = isset($words[1]) ? ucfirst($words[1][0]) : '';
                        echo $firstLetter . $secondLetter;
                    }else{
                        echo 'SI';
                    }
                    ?>
                </div>
            </li>
                            <!-- popup-Search Bar  by pretransaction -->
            <div id="search-pre" style="display: none; position: fixed; top: 20%; left: 50%; transform: translateX(-50%); width: 60%; max-height: 70vh; overflow-y: auto; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); padding: 20px; border-radius: 10px; z-index: 1000; border: 1px solid #000000; background-color: #ffffff;">
                <div class="search-input-container" style="display: flex; align-items: center; border-radius: 5px; padding: 5px; background-color: #f5f5f5; border: 1px solid #cccccc;">
                    <span class="search-symbol" style="font-size: 18px; margin-right: 10px; color: #333333;">&#128269;</span>
                    <input type="text" id="search-input" name="search_query" placeholder="Search by Pre-transaction" style="flex: 1; border: none; outline: none; padding: 8px; font-size: 16px;">
                    <button id="searchButton" onclick="performSearch()" style="background-color: #18a689; border: none; outline: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; color: #ffffff;">Search</button>
                    <button id="escapeButton" onclick="hideSearchBar()" style="background-color: #ff0000; border: none; outline: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; color: #ffffff;">Close</button>
                </div>
            </div>
            <div id="searchPopup" class="search-popup">
                <div class="search-input-container">
                    <span class="search-symbol">🔍</span>
                    <input type="text" id="searchInput" placeholder="Search..." onkeyup="searchMenuItems()" style="width: 100%; font-size: 18px; border: none;">
                    <button id="escapeButton" onclick="hideSearchPopup()"> Esc</button>
                </div>
                <ul id="searchResults"></ul>
            </div>


            <li @if(preg_match('/dashboard/i', $url)) class="active" @endif>
                <a href="{{ route('admin.dashboard') }}"><i class="fa fa-diamond"></i> <span
                        class="nav-label">Dashboard</span></a>
            </li>

            @if(auth()->user()->hasPermissionTo('Backend users view') || auth()->user()->hasPermissionTo('Backend user create'))
                <li @if($url == route('backendUser.view') || $url == route('backendUser.create'))class="active" @endif>
                    <a href="#"><i class="fa fa-vcard"></i> <span class="nav-label">Backend Users</span><span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">

                        @can('Backend users view')
                            <li><a href="{{ route('backendUser.view') }}">View backend users</a></li>
                        @endcan

                        @can('Backend user create')
                            <li><a href="{{ route('backendUser.create') }}">Create backend user</a></li>
                        @endcan

                    </ul>
                </li>
            @endif

            @if(auth()->user()->hasPermissionTo('Roles view') || auth()->user()->hasPermissionTo('Role create'))
                <li @if($url == route('role.view') || $url == route('role.create'))class="active" @endif>
                    <a href="#"><i class="fa fa-key"></i> <span class="nav-label">Roles</span><span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">

                        @can('Roles view')
                            <li><a href="{{ route('role.view') }}">View Roles</a></li>
                        @endcan

                        @can('Role create')
                            <li><a href="{{ route('role.create') }}">Create Role</a></li>
                        @endcan

                    </ul>
                </li>
            @endif








            @if(auth()->user()->hasAnyPermission(['User session log view', 'Backend user log view' , 'Auditing log view', 'Profiling log view', 'Statistics log view', 'Development log view','Api log', 'Model log']))
                <li @if(preg_match('/log/i', $url)) class="active" @endif>
                    <a href="#"><i class="fa fa-th-list"></i> <span class="nav-label">Logs</span><span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        {{--@can('User session log view')
                            <li><a href="{{ route('admin.log.userSession') }}">User Session Log</a></li>
                        @endcan--}}

                        @can('Backend user log view')
                            <li><a href="{{ route('backendLog.all') }}">Backend Log</a></li>
                        @endcan
                        {{--@can('Api log')
                            <li><a href="{{ route('apiLog.all') }}">API Log</a></li>

                        @endcan--}}

                        {{-- @can('Model log')
                            <li><a href="{{ route('model-logs') }}">Model Log</a></li>
                        @endcan --}}


                        {{--@can('Auditing log view')
                        <li><a href="{{ route('admin.log.auditing') }}">Auditing Log</a></li>
                        @endcan
                        @can('Profiling log view')
                        <li><a href="{{ route('admin.log.profiling') }}">Profiling Log</a></li>
                        @endcan
                        @can('Statistics log view')
                        <li><a href="{{ route('admin.log.statistics') }}">Statistics Log</a></li>
                        @endcan
                        @can('Development log view')
                        <li><a href="{{ route('admin.log.development') }}">Development Log</a></li>
                        @endcan--}}
                    </ul>
                </li>
            @endif

            <li @if(preg_match('/settings/i', $url)) class="active" @endif>
                <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Settings</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">

                    @can('Rebranding setting')
                        <li><a href="{{ route('settings.rebranding')}}">Rebranding Setting</a></li>
                    @endcan


                </ul>
            </li>

        </ul>
    </div>
</nav>
    <style>
            .search-popup {
                display: none;
                position: fixed;
                top: 20%;
                left: 55%;
                transform: translateX(-50%);
                width: 60%; /* Adjust the width as needed */
                max-height: 70vh;
                overflow-y: auto;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
                padding: 20px;
                border-radius: 10px;
                z-index: 1000;
                border: 1px solid #000000;
                background-color: #ffffff;
            }

            .search-input-container {
                display: flex;
                align-items: center;
                border-radius: 5px;
                padding: 5px;
                background-color: #f5f5f5;
                border: 1px solid #cccccc;

            }

            .search-symbol {
                font-size: 18px;
                margin-right: 10px;
                color: #333333;

            }

            #searchInput {
                flex: 1;
                border: none;
                outline: none;
                padding: 8px;
                font-size: 16px;
            }

            #escapeButton {
                background-color: #18a689; /* Theme color */
                border: none;
                outline: none;
                padding: 8px 15px;
                border-radius: 5px;
                cursor: pointer;
                color: #ffffff; /* Text color */
            }

            #escapeButton:hover {
                background-color: #14796d;  /* Darker shade for hover */
            }

            #escapeButton:hover {
                background-color: #ccc;
            }

            #searchResults {
                margin-top: 10px;
                list-style: none;
                padding: 0;
                max-height: 300px;
                overflow-y: auto;
            }

            .search-result-item {
                padding: 5px;
                cursor: pointer;
                transition: background-color 0.2s;
            }

            .search-result-item:hover {
                background-color: #f0f0f0;
            }
            .highlighted {
                    background-color: grey;
                    color: black;
                    font-weight: bold;
                }
    </style>
    <script>
    // Function to filter menu items based on search input
    function myFunction() {
        console.log("Function called");
        var input, filter, ul, li, a, i, subItem;
        input = document.getElementById("mySearch");
        filter = input.value.toUpperCase();
        ul = document.getElementById("side-menu");
        li = ul.getElementsByTagName("li");

        for (i = 0; i < li.length; i++) {
            a = li[i].querySelector("a");
            if (a && !a.classList.contains("dropdown-toggle")) {
                subItem = li[i].querySelector("ul");
                if (subItem && subItem.textContent.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else if (a.textContent.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }

        // After filtering, reset selected result to the first one if no results found
        if (selectedResultIndex === -1) {
            selectedResultIndex = 0;
        }

        selectResult(selectedResultIndex);
    }

    // Function to open the selected search result on "Enter" key press
    function openSelectedResult() {
        var selectedResult = document.querySelector('.search-result-item.highlighted');
        if (selectedResult) {
            var link = selectedResult.dataset.link;
            if (link) {
                window.open(link, '_blank');
            }
        }
    }

    document.getElementById('searchInput').addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent the default behavior of submitting a form
            openSelectedResult();
        }
    });

    document.addEventListener('keydown', function (event) {
        if ((event.ctrlKey || event.metaKey) && event.key === 'k') {
            event.preventDefault(); // Prevent the default Ctrl + K behavior
            showSearchPopup();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            hideSearchPopup();
        }
    });

    function showSearchPopup() {
        var searchPopup = document.getElementById('searchPopup');
        searchPopup.style.display = 'block';
        searchInput.focus();
        searchMenuItems();
    }

    function hideSearchPopup() {
        var searchPopup = document.getElementById('searchPopup');
        searchPopup.style.display = 'none';
        searchResults.innerHTML = ''; // Clear search results
        selectedResultIndex = -1; // Reset selected result index
    }

    function searchMenuItems() {
        var input = searchInput.value.trim().toUpperCase();
        var menuItems = document.querySelectorAll('#side-menu li:not(.nav-header)');

        searchResults.innerHTML = ''; // Clear previous search results

        if (input.length === 0) {
            searchResults.style.display = 'none';
            return;
        }

        searchResults.style.display = 'block';

        var hasRecentSearches = false;

        menuItems.forEach(function (menuItem, index) {
            var menuItemLink = menuItem.querySelector('a');
            if (menuItemLink) {
                var menuItemText = menuItemLink.textContent.toUpperCase();
                var isParent = menuItem.querySelectorAll('ul').length > 0;

                if (!isParent && menuItemText.includes(input)) {
                    // If it's a child item and matches the input, create and select the result
                    hasRecentSearches = true;
                    createSearchResultItem(menuItemText, menuItemLink.href, isParent);
                } else if (isParent && hasMatchingChildItems(menuItem, input)) {
                    // If it's a parent item with matching child items, create and select the result
                    hasRecentSearches = true;
                    createSearchResultItem(menuItemText, menuItemLink.href, isParent);
                }
            }
        });

        if (!hasRecentSearches) {
            var noResultsItem = document.createElement('li');
            noResultsItem.textContent = 'No results found.';
            searchResults.appendChild(noResultsItem);
        }

        // Select the first result immediately after populating the search results
        selectResult(selectedResultIndex);
    }

    // Function to select a search result by index and highlight it
    function selectResult(index) {
        var searchResultItems = document.querySelectorAll('.search-result-item');
        if (searchResultItems.length > 0) {
            // Remove the highlight from the previously selected result
            if (selectedResultIndex !== -1) {
                searchResultItems[selectedResultIndex].classList.remove('highlighted');
            }
            // Ensure the index stays within bounds
            selectedResultIndex = Math.min(Math.max(index, 0), searchResultItems.length - 1);
            // Highlight the newly selected result
            searchResultItems[selectedResultIndex].classList.add('highlighted');

            // Scroll to the selected result if it's not in view
            searchResultItems[selectedResultIndex].scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
            });
        }
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'ArrowDown') {
            event.preventDefault();
            navigateResults(1);
        } else if (event.key === 'ArrowUp') {
            event.preventDefault();
            navigateResults(-1);
        }
    });

    function navigateResults(step) {
        // Ensure there are search results to navigate
        var searchResultItems = document.querySelectorAll('.search-result-item');
        if (searchResultItems.length > 0) {
            // Calculate the new index
            var newIndex = selectedResultIndex + step;
            // Ensure the new index stays within bounds
            newIndex = Math.min(Math.max(newIndex, 0), searchResultItems.length - 1);
            // Select the new result
            selectResult(newIndex);
        }
    }

    function hasMatchingChildItems(parentItem, input) {
        var subMenu = parentItem.querySelector('ul');
        if (subMenu) {
            var subMenuItems = subMenu.querySelectorAll('li a');
            for (var i = 0; i < subMenuItems.length; i++) {
                var subMenuItemText = subMenuItems[i].textContent.toUpperCase();
                if (subMenuItemText.includes(input)) {
                    return true;
                }
            }
        }
        return false;
    }

    function createSearchResultItem(text, link, isParent) {
        var resultItem = document.createElement('li');
        resultItem.textContent = text;
        resultItem.className = 'search-result-item';
        resultItem.dataset.link = link; // Store the link as a data attribute

        if (isParent) {
            resultItem.classList.add('parent-item');
            resultItem.style.fontWeight = 'bold';
            resultItem.style.cursor = 'default';
            resultItem.addEventListener('click', function (event) {
                event.stopPropagation();
            });
        } else {
            resultItem.addEventListener('click', function () {
                window.location.href = link;
            });
        }

        searchResults.appendChild(resultItem);
    }

    const searchResults = document.getElementById('searchResults');
    const searchInput = document.getElementById('searchInput');
    let selectedResultIndex = -1; // Initialize to -1 to indicate no selection initially
    </script>
<script>
    // Function to open the search bar
    function openSearchBar() {
        var searchBar = document.getElementById("search-pre");
        searchBar.style.display = "block";
        document.getElementById("search-input").focus();
        console.log("Search bar opened");
    }

    // Function to close the search bar
    function hideSearchBar() {
        var searchBar = document.getElementById("search-pre");
        searchBar.style.display = "none";
        document.getElementById("search-input").value = ""; // Clear the search input
        console.log("Search bar closed");
    }

    // Function to perform the search and trigger filtering
    function performSearch() {
        // Get the search input value
        var searchInput = document.getElementById("search-input").value.trim();

        if (/^\d{10}$/.test(searchInput)) {
            var userSearchUrl = "/admin/users?mobile_no=" + encodeURIComponent(searchInput);
            window.open(userSearchUrl, "_blank");
            console.log("User search performed with mobile number:", searchInput);
        } else {
            var preTransactionId = searchInput;
            var queryParams = ["pre_transaction_id=" + encodeURIComponent(preTransactionId)];
            var preTransactionSearchUrl = "/admin/microservice/PreTransactions?" + queryParams.join("&");
            window.open(preTransactionSearchUrl, "_blank");
            console.log("Pre-transaction search performed with ID:", searchInput);
        }

        hideSearchBar();
    }

    // Event listener for Command/Control + P to open the search bar and prevent printing
    document.addEventListener("keydown", function (event) {
        if ((event.metaKey || event.ctrlKey) && event.key === "p") {
            event.preventDefault();
            openSearchBar();
        }
    });

    // Event listener for Escape key to close the search bar
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            hideSearchBar();
        }
    });

    // Event listener for Enter key to trigger search
    document.getElementById("search-input").addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            performSearch();
        }
    });
</script>



<style>
    .responsive-site-logo {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
    }
</style>

<?php
$primaryColor = \DB::table('rebranding_setting')->value('primary_color');
$secondaryColor = \DB::table('rebranding_setting')->value('secondary_color');
$globalTextColor = \DB::table('rebranding_setting')->value('global_text_color');
$textColor = \DB::table('rebranding_setting')->value('text_color');
$btnTextColor = \DB::table('rebranding_setting')->value('button_text_color');
$hoverColor = \DB::table('rebranding_setting')->value('hover_color');

if($primaryColor != "#2f4050"){
?>
<script>
    var primaryColor = "<?php echo $primaryColor; ?>";
    var metisMenuElements = document.querySelectorAll(".sidebar-collapse");
    for (var i = 0; i < metisMenuElements.length; i++) {
        metisMenuElements[i].style.setProperty("background-color", primaryColor, "important");
    }
    var styleTag = document.createElement('style');
    styleTag.innerHTML = `
                ul.nav-second-level, body.mini-navbar .nav-header, .navbar-default .nav > li > a:hover,
                .navbar-default .nav > li > a:focus, body {
                    background-color: ${primaryColor} !important;
                }
            `;
    document.head.appendChild(styleTag);
</script>

<?php } ?>

<?php
if($secondaryColor != "#18a689"){
?>
<script>
    var secondaryColor = "<?php echo $secondaryColor; ?>";

    var styleLiTag = document.createElement('style');
    styleLiTag.innerHTML = `
                    .navbar-default .nav > li.active {
                        border-left: 4px solid ${secondaryColor} !important;
                    }
                `;
    document.head.appendChild(styleLiTag);


    var styleBtnTag = document.createElement('style');
    styleBtnTag.innerHTML = `
                    .btn-primary, .page-item.active .page-link {
                        background-color: ${secondaryColor} !important;
                        border-color: ${secondaryColor} !important;
                    }
                `;
    document.head.appendChild(styleBtnTag);
</script>
<?php } ?>

<?php if($globalTextColor != "#212529"){ ?>
<script>
    var globalTextColor = "<?php echo $globalTextColor; ?>";

    var styleTag = document.createElement('style');
    styleTag.innerHTML = `
                body, .welcome-message {
                    color: ${globalTextColor} !important;
                }
            `;
    document.head.appendChild(styleTag);
</script>

<?php } ?>


<?php if($textColor != "#a7b1c2"){ ?>
<script>
    var textColor = "<?php echo $textColor; ?>";

    var styleTag = document.createElement('style');
    styleTag.innerHTML = `
                .nav-second-level li a ,.nav-header a, .nav-header .text-muted, .metismenu >  li > a, .logo-element{
                    color: ${textColor} !important;
                }

                .nav > li > a:hover,
                .logo-element:hover,
                .nav > li > a:focus,
                .logo-element:focus {
                    font-size: 1.1em;
                }
            `;
    document.head.appendChild(styleTag);
</script>

<?php } ?>

<?php if($btnTextColor != "#a7b1c2"){ ?>
<script>
    var btnTextColor = "<?php echo $btnTextColor; ?>";

    var styleTag = document.createElement('style');
    styleTag.innerHTML = `
                    .btn-primary{
                        color: ${btnTextColor} !important;
                    }
                `;
    document.head.appendChild(styleTag);
</script>

<?php } ?>

<?php if($hoverColor != "#a7b1c2"){ ?>
<script>
    var hoverColor = "<?php echo $hoverColor; ?>";

    var styleTag = document.createElement('style');
    styleTag.innerHTML = `
                    .nav > li > a:hover,
                    .logo-element:hover,
                    .nav > li > a:focus,
                    .logo-element:focus {
                        color: ${hoverColor} !important;
                        font-size: 1.1em;
                    }
                `;
    document.head.appendChild(styleTag);
</script>

<?php } ?>

