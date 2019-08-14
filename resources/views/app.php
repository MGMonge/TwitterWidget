<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Basic Twitter Widget</title>
    <link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">
    <link href="<?php echo mix('/assets/app.css') ?>" rel="stylesheet">
</head>
<body>
    <section class="page">
        <div class="widgets">
            <div class="widgets__item">
                <h2 class="page__title">Twitter widget with jQuery</h2>
                <div class="js-twitter_widget twitter_widget"></div>
                <script id="js-tweet-template" type="text/x-tweet-template">
                    <div class="twitter_widget__item">
                        <img class="js-profile-image">
                        <p class="js-text"></p>
                    </div>
                </script>
            </div>
            <div class="widgets__item">
                <h2 class="page__title">Twitter widget with Vue js</h2>
                <twitter-widget :interval="1"></twitter-widget>
            </div>
        </div>
    </section>
    <script src="<?php echo mix('/assets/app.js') ?>"></script>
</body>
</html>
