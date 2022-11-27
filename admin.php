<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>

        <?php
            if (!isset($_SESSION['user'])) {
                header("Location:login.php");
            } else {
                ?>
                <!-- Admin page here -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                        <button id="back_button" type="button" onclick="buttonBack()" class="btn btn-primary btn-lg btn-info mt-4 mb-4">Map</button>
                        </div>
                        <div class="col text-center">
                            <h1 class='mb-3 mt-3'>Post Queue</h1>
                        </div>
                        <div class="col text-right">
                        <button id="logout_button" type="button" onclick="buttonLogOut()" class="btn btn-primary btn-lg btn-danger mt-4 mb-4">Log out</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center mx-auto">
                            <div id="scroll-box" class="overflow-auto" style="height:90vh;"></div>
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', (event) => {
                        var card, cardImage, cardBody, cardText;

                        <?php 
                        $connection = mysqli_connect("localhost","root","","map") or die("Error " . mysqli_error($connection));
                        $sql = "select * from posts";
                        $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
                        $text = array();
                        $image = array();
                        $alt = array();
                        $id = array();
                        $approved = array();
                        while($row =mysqli_fetch_assoc($result))
                        {
                            $text[] = $row["text"];
                            $image[] = $row["image"];
                            $alt[] = $row["alt"];
                            $id[] = $row["id"];
                            $approved[] = $row["approved"];
                        }
                        ?>
                        
                        var textarr = <?php echo json_encode($text, JSON_HEX_TAG); ?>;
                        var imagearr = <?php echo json_encode($image, JSON_HEX_TAG); ?>;
                        var altarr = <?php echo json_encode($alt, JSON_HEX_TAG); ?>;
                        var idarr = <?php echo json_encode($id, JSON_HEX_TAG); ?>;
                        var approvedarr = <?php echo json_encode($approved, JSON_HEX_TAG); ?>;

                        <?php
                        mysqli_close($connection);
                        ?>

                        for (i = 0; i < textarr.length; i++) {
                            if (approvedarr[i] == 0) {
                                card = document.createElement('div');
                                card.className = 'card text-center mb-5 bg-light w-75 mx-auto';
                                card.id = "card" + idarr[i];
                                card.style = 'width: 18rem;';

                                cardImage = document.createElement('img');
                                imagenum = imagearr[i];
                                cardImage.setAttribute("src", imagenum);
                                cardImage.className = 'card-img-top';

                                cardBody = document.createElement('div');
                                cardBody.className = 'card-body';

                                cardText = document.createElement('p');
                                cardText.className = 'card-text';
                                cardText.innerHTML = textarr[i];

                                cardTextAlt = document.createElement('p');
                                cardTextAlt.className = 'card-text';

                                cardAlt = document.createElement('small');
                                cardAlt.className = 'text-muted';
                                cardAlt.innerHTML = 'alt: ' + altarr[i];

                                cardApprove = document.createElement('a');
                                cardApprove.className = 'btn btn-primary btn-lg btn-success mr-2 text-light';
                                cardApprove.id = idarr[i];
                                cardApprove.setAttribute("onClick", "buttonApprove(this.id)");
                                cardApprove.innerHTML = 'Approve'

                                cardDeny = document.createElement('a');
                                cardDeny.className = 'btn btn-primary btn-danger btn-lg text-light';
                                cardDeny.id = idarr[i];
                                cardDeny.setAttribute("onClick", "buttonDeny(this.id)");
                                cardDeny.innerHTML = 'Deny'

                                cardBody.appendChild(cardText);
                                if (altarr[i]) {
                                    cardTextAlt.appendChild(cardAlt);
                                    cardBody.appendChild(cardTextAlt);
                                }
                                cardBody.appendChild(cardApprove);
                                cardBody.appendChild(cardDeny);
                                card.appendChild(cardImage);
                                card.appendChild(cardBody);
                                document.getElementById("scroll-box").appendChild(card);
                            }
                        }
                    })
                    function buttonBack() {
                        window.location.href = "index.php";
                    }
                    function buttonLogOut() {
                        window.location.replace("logout.php");
                    }
                    function buttonApprove(elementid) {
                        var xhr = new XMLHttpRequest(); //Opens AJAX to pass id to approve.php
                        xhr.open("GET", "approve.php?id=" + elementid, true); //sends id of post to approve.php
                        xhr.send(null);
                        setTimeout(() => {  window.location.reload(); }, 100);
                    }
                    function buttonDeny(elementid) {
                        var xhr = new XMLHttpRequest(); //Opens AJAX to pass id to delete.php
                        xhr.open("GET", "delete.php?id=" + elementid, true); //sends id of post to delete.php
                        xhr.send(null);
                        setTimeout(() => {  window.location.reload(); }, 100);
                    }
                </script>
                <!-- Admin page end -->
                <?php
            }
        ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS-->
        <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>