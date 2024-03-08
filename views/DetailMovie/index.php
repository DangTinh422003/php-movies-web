<link rel="stylesheet" href="/views/DetailMovie/index.css">
<link rel="stylesheet" href="/views/Home/index.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div>
    <div class="demo-content container-fluid" style="background-image: linear-gradient(to right,#00000099,#00000099),url(https://image.tmdb.org/t/p/original<?php echo $datamovie["backdrop_path"] ?>);">
        <div class="row detail-header">
            <div class="poster-section col-lg-4 col-md-12 col-sm-12 col-12">
                <?php
                $poster = $datamovie["poster_path"];
                echo "<img id=poster src='https://image.tmdb.org/t/p/w500$poster' width=80%>";
                ?>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                <div id="content_section">
                    <h2 id="movie_title"><?php
                                            if ($datamovie["title"] != null) {
                                                echo $datamovie["title"];
                                            }
                                            ?></h2>
                    <p id="movie_category">Thể loại: <?php foreach ($genres as $value) {
                                                            echo $value["name"] . ", ";
                                                        } ?></p>
                    <p id="movie_ep">Năm phát hành: <?php echo $datamovie["release_date"] ?></p>
                    <p id="nation">Quốc gia: <?php echo $datamovie["country"] ?></p>
                    <p id="desc"><?php echo $datamovie["tagline"] ?></p>
                    <div id="btn_section" class="container-fluid">
                        <div class="row justify-content-md-center justify-content-sm-center">
                            <div class="col">
                                <button type="button" class="btn smallbtn"><i class="fa fa-heart-o" style="font-size: 16px;text-align: center;margin: auto;" aria-hidden="true"></i></button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn smallbtn"><i class="fa fa-star-o" style="font-size: 16px;text-align: center;margin: auto" aria-hidden="true"></i></button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn smallbtn"><i class="fa fa-bookmark-o" style="font-size: 16px;text-align: center;margin: auto" aria-hidden="true"></i></button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn smallbtn" id="play_btn" 
                                        data-id=<?php echo '"' . $datamovie["id"] . '"' ?> 
                                        data-user=<?php
                                                if (isset($_SESSION["name"])) {
                                                    echo '"' . $_SESSION["name"] . '"';
                                                } else {
                                                    echo '"' . '"';
                                                } ?> >
                                    <i class="fa fa-play play_icon" style="font-size: 16px;text-align: center;margin: auto" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="col-6"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="body_content">
        <hr style="height: 5px;margin: auto;border-radius: 43px;width: 50%;background-color: #00CC21;" />
        <h3 class="s_header">Overview</h3>
        <?php
        $overview = $datamovie["overview"];
        if ($overview != null) {
            echo "<p id=movie_desc>" . $overview . "</p>";
        } else {
            echo "<h1 id=movie_desc>No data available</h1>";
        }
        ?>
        <h3 class="s_header">Trailer</h3>
        <div id="trailer">
            <?php
            $link = $datamovie["trailer_key"];
            if ($link != null) {
                echo  "<iframe width=900 height=507 src=https://www.youtube.com/embed/" . $link . " title=YouTube video player frameborder=0 allow=accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share allowfullscreen></iframe>";
            } else {
                echo "<h1 id=" . "movie_desc>" . "No data available</h1>";
            }

            ?>
        </div>
        <hr style="margin:4% auto auto auto;border-radius: 43px;width: 50%;border: solid 3px #00CC21;background-color: #00CC21;" />
        <h3 class="s_header">Casts</h3>
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">

                        <?php for ($i = 0; $i < 6; $i++) {
                            $castname = $castsmovie[$i]["name"];
                            $castimg = "https://image.tmdb.org/t/p/w500" . $castsmovie[$i]["profile_path"];
                            if ($castimg != "https://image.tmdb.org/t/p/w500") {
                                echo "
                                <div class=col-md-2 col-6 mb-3>
                                    <div class=card g-0 bg-transparent>
                                        <img src=" . $castimg . " class=card-img-top rounded alt=...>
                                        <div class=card-body style=height:100px>
                                            <div class=card-title> <p class=actor_name >" . $castname . "</p> </div>
                                        </div>
                                    </div>
                                </div>";
                            } else {
                                $castimg = "/assets/img/blank-profile.png";

                                echo "
                                    <div class=col-md-2 col-6 mb-3>
                                        <div class=card g-0 bg-transparent>
                                            <img src=" . $castimg . " class=card-img-top rounded alt=...>
                                            <div class=card-body style=height:100px>
                                                <div class=card-title> <p class=actor_name>" . $castname . "</p> </div>
                                            </div>
                                         </div>
                                     </div>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php
                if (count($castsmovie) > 6) {
                    echo "<div class=carousel-item>
                             <div class=row>";
                    for ($i = 6; $i < 12; $i++) {
                        $castname = $castsmovie[$i]["name"];
                        $castimg = "https://image.tmdb.org/t/p/w500" . $castsmovie[$i]["profile_path"];
                        if ($castimg != "https://image.tmdb.org/t/p/w500") {
                            echo "
                                <div class=col-md-2 col-6 mb-3>
                                    <div class=card g-0 bg-transparent>
                                        <img src=" . $castimg . " class=card-img-top rounded alt=...>
                                        <div class=card-body style=height:100px>
                                            <div class=card-title> <p class=actor_name>" . $castname . "</p> </div>
                                        </div>
                                     </div>
                                 </div>";
                        } else {
                            $castimg = "/assets/img/blank-profile.png";

                            echo "
                                <div class=col-md-2 col-6 mb-3>
                                    <div class=card g-0 bg-transparent>
                                        <img src=" . $castimg . " class=card-img-top rounded alt=...>
                                        <div class=card-body style=height:100px>
                                            <div class=card-title> <p class=actor_name>" . $castname . "</p> </div>
                                        </div>
                                     </div>
                                 </div>";
                        }
                    }
                    echo "</div>
                            </div>";
                }
                ?>
            </div>
        </div>
        <hr style="margin:4% auto auto auto;border-radius: 43px;width: 50%;border: solid 3px #00CC21;background-color: #00CC21;" />
        <h3 class="s_header">Comments</h3>
        <div id="comment_section" class="container">
            <p id="number_cmt">Binh Luan</p>
            <div class="row">
                <form id="comment_form" method="get">
                    <div class="form-outline">
                        <textarea class="form-control" id="comment_area" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary comment_btn">Send</button>
                </form>
            </div>
            <div id="cmt"></div>
        </div>
        <hr style="margin:4% auto auto auto;border-radius: 43px;width: 50%;border: solid 3px #00CC21;background-color: #00CC21;" />
        <h3 class="s_header">Recommendation</h3>
        <div class="container py-5">
            <h3 class="titleGenre text-light">Phim đề xuất</h3>
            <div class="row mt-5 recommendFilmsContainer">



            </div>
        </div>
    </div>

    <div id="data-id" data-id=<?php echo '"' . $datamovie["id"] . '"' ?> data-user=<?php
                                                                                    if (isset($_SESSION["name"])) {
                                                                                        echo '"' . $_SESSION["name"] . '"';
                                                                                    } else {
                                                                                        echo '"' . '"';
                                                                                    } ?>></div>
</div>
</div>
<script src="/views/DetailMovie/index.js"></script>