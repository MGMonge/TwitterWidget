<template>
    <div class="twitter_widget">
        <p v-if="busy" class="twitter_widget__loading">Checking for new tweets...</p>
        <div class="twitter_widget__item" v-for="tweet in tweets">
            <img :src="tweet.user.profile_image_url_https">
            <p>{{ tweet.text }}</p>
        </div>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    props: {
        /**
         * Interval in minutes
         */
        interval: {
            required: true,
            type: Number
        }
    },

    data() {
        return {
            busy: false,
            tweets: []
        }
    },

    created() {
        this.fetchTweets()
    },

    methods: {
        fetchTweets() {
            this.busy = true

            axios.get('/tweets').then((response) => {
                this.tweets = response.data

                setTimeout(this.fetchTweets, this.interval * 60 * 1000)

                this.busy = false
            })
        }
    }
}
</script>