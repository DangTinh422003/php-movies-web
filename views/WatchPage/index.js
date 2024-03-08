const video_player = document.querySelector('#video_player'),
mainVideo = video_player.querySelector('#main_videos'),
progressiveAreaTime=video_player.querySelector('.progressiveAreaTime'),
controls=video_player.querySelector('.controls'),
progressArea=video_player.querySelector('.progress-area'),
progressBar=video_player.querySelector('.progress-bar'),
replay10=video_player.querySelector('.replay_10'),
play_pause=video_player.querySelector('.play_pause'),
forward10=video_player.querySelector('.forward_10'),
volume=video_player.querySelector('.volume'),
volume_range=video_player.querySelector('.volume_range'),
current=video_player.querySelector('.current'),
totalDuration=video_player.querySelector('.duration'),
setting=video_player.querySelector('.setting'),
fullscreen=video_player.querySelector('.fullscreen'),
settings=video_player.querySelector('#settings'),
playback=video_player.querySelectorAll('.playback li');


// #play and pause
function playVideo() {
    play_pause.innerHTML="pause";
    play_pause.title="pause";
    video_player.classList.add('paused')
    mainVideo.play();
}

function pauseVideo(){

    play_pause.innerHTML="play_arrow";
    play_pause.title="play";
    video_player.classList.remove('paused')
    mainVideo.pause();
}

play_pause.addEventListener('click',()=>{
    const isVideoPaused = video_player.classList.contains('paused');
    isVideoPaused ? pauseVideo() : playVideo();
})

mainVideo.addEventListener('play',()=>{
    playVideo();
})

mainVideo.addEventListener('pause',()=>{
    pauseVideo();
})
//#rewind and forward

replay10.addEventListener('click',()=>{
    mainVideo.currentTime -=10;
})

forward10.addEventListener('click',()=>{
    mainVideo.currentTime +=10;
})

//video thoi luong
mainVideo.addEventListener("loadeddata", (e) => {
    let videoDuration = e.target.duration;
    let totalMin = Math.floor(videoDuration / 60);
    let totalSec = Math.floor(videoDuration % 60);

    // if seconds are less then 10 then add 0 at the begning
    totalSec < 10 ? (totalSec = "0" + totalSec) : totalSec;
    totalDuration.innerHTML = `${totalMin} : ${totalSec}`;
});

mainVideo.addEventListener("timeupdate", (e) => {
    let currentVideoTime = e.target.currentTime;
    let currentMin = Math.floor(currentVideoTime / 60);
    let currentSec = Math.floor(currentVideoTime % 60);
    currentSec < 10 ? (currentSec = "0" + currentSec) : currentSec;
    current.innerHTML = `${currentMin} : ${currentSec}`;
    let videoDuration = e.target.duration;
    let progressWidth = (currentVideoTime / videoDuration) * 100 + 0.5;
    progressBar.style.width = `${progressWidth}%`;
});

progressArea.addEventListener("pointerdown", (e) => {
    progressArea.setPointerCapture(e.pointerId);
    setTimelinePosition(e);
    progressArea.addEventListener("pointermove", setTimelinePosition);
    progressArea.addEventListener("pointerup", () => {
    progressArea.removeEventListener("pointermove", setTimelinePosition);
    })
});

function setTimelinePosition(e) {
    let videoDuration = mainVideo.duration;
    let progressWidthval = progressArea.clientWidth + 2;
    let ClickOffsetX = e.offsetX;
    mainVideo.currentTime = (ClickOffsetX / progressWidthval) * videoDuration;

    let progressWidth = (mainVideo.currentTime / videoDuration) * 100 + 0.5;
    progressBar.style.width = `${progressWidth}%`;

    let currentVideoTime = mainVideo.currentTime;
    let currentMin = Math.floor(currentVideoTime / 60);
    let currentSec = Math.floor(currentVideoTime % 60);
    // if seconds are less then 10 then add 0 at the begning
    currentSec < 10 ? (currentSec = "0" + currentSec) : currentSec;
    current.innerHTML = `${currentMin} : ${currentSec}`;

}

// change volume
function changeVolume() {
    mainVideo.volume = volume_range.value / 100;
    if (volume_range.value == 0) {
        volume.innerHTML = "volume_off";
    } else if (volume_range.value < 40) {
        volume.innerHTML = "volume_down";
    } else {
        volume.innerHTML = "volume_up";
    }
}

function muteVolume() {
if (volume_range.value == 0) {
    volume_range.value = 80;
    mainVideo.volume = 0.8;
    volume.innerHTML = "volume_up";
} else {
    volume_range.value = 0;
    mainVideo.volume = 0;
    volume.innerHTML = "volume_off";
}
}

volume_range.addEventListener("change", () => {
    changeVolume();
});

volume.addEventListener("click", () => {
    muteVolume();
});



//thay doi speed
setting.addEventListener('click',()=>{
    settings.classList.toggle('active');
    setting.classList.toggle('active');
})
 
function removeActiveClasses(){
    playback.forEach(event => {
        event.classList.remove('active')
    });
}

playback.forEach((event)=>{
    event.addEventListener('click',()=>{
        removeActiveClasses();
        event.classList.add('active');
        let speed = event.getAttribute('data-speed');
        mainVideo.playbackRate=speed;
    })
})

//full screen
fullscreen.addEventListener('click',()=>{
    if(!video_player.classList.contains('openFullScreen')){
        video_player.classList.add('openFullScreen');
        fullscreen.innerHTML='fullscreen_exit';
        video_player.requestFullscreen();
    }else{
        video_player.classList.remove('openFullScreen');
        fullscreen.innerHTML="fullscreen";  
        document.exitFullscreen();
    }
})

mainVideo.addEventListener("contextmenu", (e) => {
    e.preventDefault();
  });

//di chuyen chuot 
video_player.addEventListener('mouseover',()=>{
    controls.classList.add('active');
})

video_player.addEventListener('mouseleave',()=>{
    if(video_player.classList.contains('paused')){
            if(setting.classList.contains('active')){
                controls.classList.add('active');
            }else{
                controls.classList.remove('active');
            }
    }else{
        controls.classList.add('active');
    }
})

let timer;
const hideControls = () => {
if (mainVideo.paused) return;
timer = setTimeout(() => {
    if (settingsBtn.classList.contains("active") || captionsBtn.classList.contains("active")) {
    controls.classList.add("active");
    } else {
    controls.classList.remove("active");
    if (tracks.length != 0) {
        caption_text.classList.add("active");
    }
    }
}, 3000);
}

$(function () {
    $.get("/", { getRecommendMovies: true }, function (data) {
      let filmsData = JSON.parse(data)
  
      let recommendFilmsContainer = $(".recommendFilmsContainer")
      filmsData.data.forEach(function (film) {
  
        let poster = "https://image.tmdb.org/t/p/w500" + film.poster_path
        let release_date = new Date(film.release_date)
  
        let html = `
        <div class="col-lg-2 text-light">
        <div class="bg-transparent card me-1 g-0 w-100" style="width: 18rem;">
          <div class="watchLink position-relative" data-id="${film.id}">
            <img src="${poster}" class="card-img-top rounded watchThumbnail" alt="...">
            <h3 class="position-absolute top-50 start-50 translate-middle text-light">Xem ngay</h3>
          </div>
          <div class="card-body">
            <h5 class="card-title linkToDetail style="color:white" data-id="${film.id}">${film.title}</h5>
            <div class="card-subInf d-flex justify-content-between">
              <p class="card-text text-secondary">${release_date.getFullYear()}</p>
              <div class="favouriteTotal d-flex">
                <i class="fa-solid fa-heart me-2"></i>
                <p>lượt thích:</p>
                <b>50</b>
              </div>
            </div>
          </div>
        </div>
      </div>
        `
        recommendFilmsContainer.append(html)
  
      })
      $(".watchLink").click(function (e) {
        let id=$(e.target).parent(".watchLink").attr("data-id")
        console.log(id)
        window.location.href = "/watch?id="+id
      })
      $(".linkToDetail").click(function (e) {
        let id=$(e.target).attr("data-id")
        window.location.href = "/detail?id="+id
      })
    })
})
   

