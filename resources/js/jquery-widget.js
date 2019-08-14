window.jQuery = window.$ = require('jquery')

const tweetTemplate = $('#js-tweet-template').html()
const TWITTER_INTERVAL = 1000 * 60

const refreshTweets = () => {
    $('.js-twitter_widget').html('<p class="twitter_widget__loading">Checking for new tweets...</p>')

    $.get('/tweets', (response) => {
        let html = ''

        JSON.parse(response).forEach((tweet) => {
            $tweet = $(tweetTemplate).clone()

            $tweet.find('.js-profile-image').attr('src', tweet.user.profile_image_url_https)
            $tweet.find('.js-text').html(tweet.text)

            html += $tweet[0].outerHTML
        })

        $('.js-twitter_widget').html(html)
        $('.js-loading').html('')
    });

    setTimeout(() => {
        refreshTweets()
    }, TWITTER_INTERVAL)
}

$(document).ready(() => {
    refreshTweets()
})