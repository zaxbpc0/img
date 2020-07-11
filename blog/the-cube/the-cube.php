<?php
/**
* THE-CUBE
*
* @package custom
*/
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="author" content="Boris Sehovac">
  <meta name="description" content="See if you can solve this classic puzzle game.">
  <meta name="viewport" content="width=device-width,height=device-height,user-scalable=no,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0">

  <title>The Cube - A Rubik's Cube Game</title>
  <meta property="og:description" content="See if you can solve this classic puzzle game."/>
  <meta property="og:image" content="https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/icons/meta-image.png"/>
  <meta property="og:site_name" content="The Cube - A Rubik's Cube Game"/>
  <meta property="og:title" content="The Cube - A Rubik's Cube Game"/>
  <meta property="og:type" content="website"/>
  <meta property="og:url" content="https://bsehovac.github.io"/>

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:creator" content="@BorisSehovac">
  <meta name="twitter:title" content="The Cube - A Rubik's Cube Game">
  <meta name="twitter:image" content="https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/icons/twitter-card.png">
  <meta name="twitter:description" content="See if you can solve this classic puzzle game.">

  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="The Cube">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="translucent-black">

  <link rel="apple-touch-icon" sizes="180x180" href="https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/icons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/icons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/icons/favicon-16x16.png">
  <link rel="manifest" href="https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/icons/site.webmanifest">
  <link rel="mask-icon" href="https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/icons/safari-pinned-tab.svg" color="#5bbad5">
  <link rel="shortcut icon" href="https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/icons/favicon.ico">
  <meta name="theme-color" content="#ffffff">

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/css/styles.css">

  <script>
    window.gameVersion = '0.99.2';
  </script>

</head>
<body>

  <div class="ui">

    <div class="ui__background"></div>

    <div class="ui__game"></div>

    <div class="ui__texts">
      <h1 class="text text--title">
        <span>THE</span>
        <span>CUBE</span>
      </h1>
      <div class="text text--note">
        Double tap to start
      </div>
      <div class="text text--timer">
        0:00
      </div>
      <div class="text text--complete">
        <span>Complete!</span>
      </div>
      <div class="text text--best-time">
        <icon trophy></icon>
        <span>Best Time!</span>
      </div>
    </div>

    <div class="ui__prefs">
      <range name="size" title="Cube Size" list="2,3,4,5"></range>
      <range name="flip" title="Flip Type" list="Swift&nbsp;,Smooth,Bounce"></range>
      <range name="scramble" title="Scramble Length" list="20,25,30"></range>
      <range name="fov" title="Camera Angle" list="Ortographic,Perspective"></range>
      <range name="theme" title="Color Scheme" list="Cube,Erno,Dust,Camo,Rain"></range>
    </div>

    <div class="ui__theme">
      <range name="hue" title="Hue" color></range>
      <range name="saturation" title="Saturation" color></range>
      <range name="lightness" title="Lightness" color></range>
    </div>

    <div class="ui__stats">
      <div class="stats" name="cube-size">
        <i>Cube:</i><b>3x3x3</b>
      </div>
      <div class="stats" name="total-solves">
        <i>Total solves:</i><b>-</b>
      </div>
      <div class="stats" name="best-time">
        <i>Best time:</i><b>-</b>
      </div>
      <div class="stats" name="worst-time">
        <i>Worst time:</i><b>-</b>
      </div>
      <div class="stats" name="average-5">
        <i>Average of 5:</i><b>-</b>
      </div>
      <div class="stats" name="average-12">
        <i>Average of 12:</i><b>-</b>
      </div>
      <div class="stats" name="average-25">
        <i>Average of 25:</i><b>-</b>
      </div>
    </div>

    <div class="ui__buttons">
      <button class="btn btn--bl btn--stats">
        <icon trophy></icon>
      </button>
      <button class="btn btn--br btn--prefs">
        <icon settings></icon>
      </button>
      <button class="btn btn--bl btn--back">
        <icon back></icon>
      </button>
      <button class="btn btn--br btn--theme">
        <icon theme></icon>
      </button>
      <button class="btn btn--br btn--reset">
        <icon reset></icon>
      </button>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/js/three.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/js/cube.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/upup.min.js"></script>
  <script>
    if (UpUp !== null) {
      UpUp.start({
        'cache-version': window.gameVersion,
        'content-url': 'index.html',
        'assets': [ 'https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/css/styles.css', 'https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/js/three.js', 'https://cdn.jsdelivr.net/gh/zaxbpc0/img/blog/the-cube/assets/js/cube.js' ]
      });
    }
  </script>
</body>
</html>