<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Map</title>
    <!-- Tab Icon-->
    <link rel="icon" type="image/x-icon" href="assets/tabicon.png" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel = "stylesheet" href = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css"/>

    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script>
        function resetTextField(){
            document.getElementById("altText").value="";
            document.getElementById("imageResult").innerHTML='0/50';
            document.getElementById("imageResult").style.color="#737373";
            document.getElementById("altText").style.borderColor="#ced4da";
        }
    </script>
</head>

<!-- Page content-->
<body>

<script>
    // Script to show the toast on return from insert.php
    document.addEventListener('DOMContentLoaded', function () {
        var url = window.location.search;
        url = url.replace("?", '');
        if (url == "0") {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl)
            })
            toastList.forEach(toast => toast.show())
        }
    });
</script>
<div id="container">
    <!-- Toast -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 3;">
        <div class="toast hide text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Success!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body mb-1">
                Your post has been submitted for review
            </div>
        </div>
    </div>

    <!-- OSM map-->
    <div id = "map" style = "width: 100vw; height: 100vh; z-index: 1; position: absolute; top: 0; left: 0;"></div>
    <script src = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
    <script type="text/javascript" src="https://stamen-maps.a.ssl.fastly.net/js/tile.stamen.js?v1.3.0"></script>
    <script>
        // vars
        var selectPin = L.marker([0,0], opacity = 0);

        // Creating map options - coordinates are the Gateway Arch
        var mapOptions = {
            center: [38.6253112804894, -90.18671821476585],
            zoom: 12
        }

        // Creating a map object
        var map = new L.map('map', mapOptions);

        // --- Layers --- //
        // Currently not used -- here for convenience if we want to change how the map looks
        var Default_Terrain = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

        // Better looking layer in my opinion
        var Stamen_Terrain = new L.TileLayer('https://stamen-tiles.a.ssl.fastly.net/terrain/{z}/{x}/{y}.jpg');
        // -------------- //

        // Adding the base layer to the map
        map.addLayer(Stamen_Terrain);

        // Pointer pin
        selectPin.addTo(map);

        // Coordinate click technology!
        map.on('click', function(e) {
            selectPin.setLatLng([e.latlng.lat, e.latlng.lng]);
            selectPin.setOpacity(1);
            mapClicked(e.latlng.lat, e.latlng.lng);
        });

        // Adding a marker to the map
        //tempMarker = L.marker([38.6253112804894, -90.18671821476585], riseOnHover=true).addTo(map);

        // Adding a popup to the marker
        // The popup is really just a <div> so you can put any kind of HTML you want into bindPopup() and it'll work!
        //tempMarker.bindPopup('<center>This is a test message!</center><br/>' + '<img src="https://static.pexels.com/photos/189349/pexels-photo-189349.jpeg" height="150px" width="150px"/>');

        // Add all markers from the database
        <?php
        $connection = mysqli_connect("localhost","root","","map") or die("Error " . mysqli_error($connection));
        $sql = "select * from posts";
        $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
        $text = array();
        $image = array();
        $alt = array();
        $lat = array();
        $lng = array();
        $approved = array();
        $id = array();

        while($row =mysqli_fetch_assoc($result))
        {
            $text[] = $row["text"];
            $image[] = $row["image"];
            $alt[] = $row["alt"];
            $lat[] = $row["lat"];
            $lng[] = $row["lng"];
            $approved[] = $row["approved"];
            $id[] = $row["id"];
        }
        ?>

        var textarr = <?php echo json_encode($text, JSON_HEX_TAG); ?>;
        var imagearr = <?php echo json_encode($image, JSON_HEX_TAG); ?>;
        var altarr = <?php echo json_encode($alt, JSON_HEX_TAG); ?>;
        var latarr = <?php echo json_encode($lat, JSON_HEX_TAG); ?>;
        var lngarr = <?php echo json_encode($lng, JSON_HEX_TAG); ?>;
        var approvedarr = <?php echo json_encode($approved, JSON_HEX_TAG); ?>;
        var idarr = <?php echo json_encode($id, JSON_HEX_TAG); ?>;

        <?php
        mysqli_close($connection);
        ?>

        for (i = 0; i < idarr.length; i++) {
            if (approvedarr[i] == 1) {
                currentMarker = L.marker([latarr[i], lngarr[i]], riseOnHover=true).addTo(map);
                popupContents = '<hr/><div class="text-center mb-2"><p class="mb-0" style="font-size: 1.25em;">' + textarr[i] + '</p></div>';
                if (imagearr[i]) {
                    popupImage = '<hr/><img src="' + imagearr[i] + '" height="150px"/>';
                    popupAlt = '<div class="text-center mb-4"><small><i>' + "Description: " + altarr[i] + '</i></small></div>';
                    popupContents = popupImage.concat(popupContents);
                    popupContents = popupContents.concat(popupAlt);
                    currentMarker.bindPopup(popupContents, {maxWidth : "auto"});
                } else {
                    currentMarker.bindPopup(popupContents, {minWidth : 300});
                }
            }
        }
    </script>

    <!--Logo: centered to the top of the page, uses fluid container to dynamically resize in accordance to the window size-->
    <div class="logo" style="z-index: 2; position: absolute; top: 0; left: 50%; transform:translate(-25%, 0%)">
        <img src="assets/logonospace.png" class="img-fluid" alt="We are STL logo" style="display: block; width:50%;">
    </div>
</div>


<div class="map-button">
    <div class="button-position">
        <div>
            <!--INFO PAGE-->
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                    aria-controls="offcanvasExample"> Info
            </button>

            <div class="offcanvas offcanvas-start"  data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasExample"
                 aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div>
                        <p>
                            <b>We Are St. Louis</b> <br>
                            <i>We Are St. Louis</i> is an online public history and storytelling project designed by a team of dedicated scholar-activists at the University of Missouri-St. Louis.  <br />
                            <br /><i>We Are St. Louis</i> first aims to serve as a publicly accessible, curated living digital collection that illuminates the network of oppressive systems in the region, while also lifting up the social change, creation, and joy that has long been undertaken by St. Louisans. The city of St. Louis and the broader region has a complex history of violence and oppression, but also a rich history of activism and resistance, from the Dred Scott decision to the Ferguson Uprising.<br />
                            <br />While there are other archives, historical sites, and scholarly projects that represent some of St. Louis' past, present, and future, there is no publicly accessible virtual home in which scholars, community members and general visitors can engage in stories and analysis of St. Louis' struggles and strengths. <i>We Are St. Louis</i> aims to fill that gap and to amplify and support often unheard or unarchived local stories, histories, and perspectives of St. Louisans in the process.<br />
                        <hr>

                        <b> Moderation</b>
                        <br>Posts to <i>We Are St. Louis</i> are moderated by a small group of volunteers before they appear publically on the map. This to ensure no hate speech, spam or breaches of anonymity are added to the site.</br>
                        <br>Depending on the amount of posts that have been made, there may be a moderation backlog. However, <i>We Are St. Louis</i> are doing the best to publish posts as quickly as we can. If you see anything you feel should be removed, or would like something you posted to be deleted, please contact us!</br>
                        <hr>

                        <b>Contact</b>
                        <br /><b>We Are St. Louis Project Directors</b><br />
                        <br /><b>Dr. Lara Kelland (she/they);</b> lara.kelland@umsl.edu<br />
                        <br />E. Desmond Lee Endowed Professor in Museum Studies and Community History
                        <br />Director of the Museums, Heritage, and Public History MA and Graduate Certificate
                        <br />Department of History
                        <br />University of Missouri-St. Louis<br />
                        <br /><b>Dr. Lauren Obermark (she/her); </b> obermarkl@umsl.edu<br />
                        <br /> Associate Professor
                        <br /> Department of English
                        <br /> University of Missouri-St. Louis
                        <br />

                        <hr>
                        <a href="login.php">Admin Sign In</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!--CREATE A POST PAGE-->
        <div>
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                    aria-controls="offcanvasRight">Create a Post</button>

            <div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasRightLabel">How to Create a Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <!--Create a post directions-->
                <div class="offcanvas-body">
                    <p class="text-left">1. Click on the location of your story.</p>
                    <p class="text-left">2. Share your story in the text box below.</p>
                    <p class="text-left">3. (Optional) Add an image. Supported file types are: PNG and JPG. If uploading an image, please describe your image in the alt text box field.</p>
                    <p class="text-left">4. Click submit!</p>
                    <hr>

                    <!--user input form-->
                    <form name = "inputForm" id = "inputForm"  action = "insert.php" method = POST
                          enctype = "multipart/form-data">
                        <!--Text label + textbox-->
                        <div class="form-group">
                            <label class="form-label mt-1" for="userText">Text:</label>
                            <textarea class="form-control" id="userText" name="userText" rows="4" required
                                      placeholder="Enter Your Story Here ...."></textarea>
                            <!-- <span class ="error_form" id = "text_error_message"> </span> -->
                            <div class="textAdded">
                                <p id="result">0/280</p>
                            </div>
                        </div>

                        <!--image & reset file-->
                        <div class = "input-group">
                            <div class="form-outline">
                                <label class="form-label mt-4" for="userImage">Image:</label>
                                <input onchange="resetTextField();" type="file" class="form-control" id="userImage" name="userImage"
                                       accept= ".jpg, .jpeg, .png, .gif, .bmp"/>
                                <!-- <span class ="error_form" id = "userImage_error_message"> </span> -->
                            </div>
                        </div>

                        <button id ="resetfile" class="btn btn-secondary btn-sm mt-1 mb-3" type="button" onclick="resetFile()">Reset file</button>

                        <!--image preview-->
                        <div class="image-preview" id="imagePreview">
                            <img id="imgPre" src="" alt="Image Preview" class="image-preview__image">
                            <span class="image-preview__default-text">Image Preview</span>
                        </div>

                        <!--image alt text-->

                        <div class="form-group">
                            <label class="form-label mt-3" for="altText">Describe your image:</label>
                            <input name="altText" type="text" class="form-control" id="altText" placeholder="ex: A family having a picnic under the Arch">
                        </div>
                        <div class = "imageTextAdded">
                            <p id ="imageResult"></p>
                        </div>
                        <div class="text-danger text-center mb-2" id="selectLocationMessage">Please click on the map to select the location of your story</div>
                        <button id="theSubmitButton" name="submit" type = "submit"
                                class="btn btn-primary mt-4" value="insert">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JS-->
<script src="./js/map.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

