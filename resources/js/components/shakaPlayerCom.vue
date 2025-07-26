<!-- ShakaPlayer.vue -->
<template>
    <div class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50">
        <div class="w-full max-w-5xl relative">
            <button
                class="absolute top-2 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-black/30 hover:bg-black/50 text-white text-2xl z-10 transition-colors duration-200 backdrop-blur-sm"
                @click="$emit('close')" aria-label="Close">
                ✕
            </button>

            <div ref="videoContainer" class="w-full h-auto">
                <video ref="videoRef" autoplay playsinline class="shaka-video w-full h-auto"></video>
                <!-- Controls will be added by Shaka UI -->
                <div class="shaka-controls-container"></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import shaka from 'shaka-player/dist/shaka-player.ui.js'
import 'shaka-player/dist/controls.css'

const props = defineProps({
    videoUrl: String,
})
const videoRef = ref(null)
const videoContainer = ref(null)

onMounted(() => {
    if (shaka.Player.isBrowserSupported()) {
        initPlayer()
    } else {
        console.error('Shaka Player not supported on this browser.')
    }
})

function initPlayer() {
    const video = videoRef.value
    const container = videoContainer.value

    const uiConfig = {
        controlPanelElements: [
            'play_pause',
            'time_and_duration',
            'spacer',
            'mute',
            'volume',
            'fullscreen',
            'overflow_menu',
        ],
        overflowMenuButtons: [
            'captions',
            'quality',
            'language',
            'playback_rate',
        ],
    }

    const player = new shaka.Player(video)
    const ui = new shaka.ui.Overlay(player, container, video)
    ui.configure(uiConfig)

    const controls = ui.getControls()

    player.addEventListener('error', onErrorEvent)

    if (props.videoUrl) {
        player
            .load(props.videoUrl)
            .then(() => console.log('Video loaded with custom UI'))
            .catch(onError)
    }
}

function onErrorEvent(event) {
    onError(event.detail)
}
function onError(error) {
    console.error('Shaka error', error.code, error)
}
</script>

<style scoped>
/* You can override or extend Shaka UI styles here */
.shaka-video {
    border-radius: 0.5rem;
}

.shaka-controls-container {
    /* no need to add anything unless customizing */
}
</style>
