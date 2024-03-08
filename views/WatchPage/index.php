<script src=" https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js "></script>
<link href=" https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css " rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
<link rel="stylesheet" href="/views/WatchPage/style.css" />
<link rel="stylesheet" href="/views/DetailMovie/index.css" />
<link rel="stylesheet" href="/views/Home/index.css">




<section>

    <div class="container mt-5 d-flex flex-column align-items-start">
        <div id="video_player">
            <video autoplay id="main_videos">
                <source src="/views/WatchPage/test.mp4" type="video/mp4">
            </video>
            <div class="progressiveAreaTime"></div>

            <div class="controls">
                <div class="progress-area">
                    <div class="progress-bar">
                        <span>
                        </span>
                    </div>
                </div>
                <div class="controls-list">
                    <div class="controls-left">
                        <span class="icon">
                            <i class="material-icons replay_10">replay_10</i>
                        </span>
                        <span class="icon">
                            <i class="material-icons play_pause">play_arrow</i>
                        </span>
                        <span class="icon">
                            <i class="material-icons forward_10">forward_10</i>
                        </span>
                        <span class="icon">
                            <i class="material-icons volume">volume_up</i>
                            <span id="vl">
                                <input type="range" min="0" max="100" class="volume_range">
                            </span>
                        </span>
                        <div class="timer">
                            <span class="current">0:00</span> / <span class="duration">0:00</span>
                        </div>
                    </div>
                    <div class="controls-right">
                        <span class="icon">
                            <i class="material-icons setting">settings</i>
                        </span>
                        <span class="icon">
                            <i class="material-icons fullscreen">fullscreen</i>
                        </span>
                    </div>
                </div>
            </div>
            <div id="settings">
                <div class="playback">
                    <span>Tốc độ</span>
                    <ul>
                        <li data-speed="0.25">0.25</li>
                        <li data-speed="0.5">0.5</li>
                        <li data-speed="0.75">0.75</li>
                        <li data-speed="1.0" class="active">1</li>
                        <li data-speed="1.25">1.25</li>
                        <li data-speed="1.5">1.5</li>
                        <li data-speed="1.75">1.75</li>
                        <li data-speed="2.0">2</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="content">
            <h1><?php echo $result["title"]; ?></h1>
            <p><?php echo $result["overview"]; ?></p>
        </div>
        <hr style="margin:4% auto auto auto;border-radius: 43px;width: 50%;border: solid 3px #00CC21;background-color: #00CC21;" />
        <div class="container py-5">
            <h3 class="titleGenre text-light">Phim đề xuất</h3>
            <div class="row mt-5 recommendFilmsContainer">

            </div>
        </div>
    </div>
</section>

<script src="views/WatchPage/index.js"> </script>