<style>
  #preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    mix-blend-mode: difference;
  }
  #preloader.hide {
    opacity: 0;
    transition: opacity 1s ease;
  }
</style>

<div id="preloader">
  <lottie-player
    src="/lottie/y2k.json"
    background="transparent"
    speed="1"
    style="width: 500px; height: 500px;"
    loop
    autoplay
  ></lottie-player>
</div>

<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<script>
  window.addEventListener("load", function() {
    const preloader = document.getElementById("preloader");
    if (preloader) {
      preloader.classList.add("hide");
      setTimeout(() => {
        preloader.remove();
      }, 1000);
    }
  });
</script>
