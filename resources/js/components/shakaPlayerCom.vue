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
          <div class="shaka-controls-container"></div>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { onMounted, onBeforeUnmount, ref } from 'vue'
  import shaka from 'shaka-player/dist/shaka-player.ui.js'
  import 'shaka-player/dist/controls.css'

  const props = defineProps({
    videoUrl: String,
    isDrm: Boolean,
    licenseToken: String,
    licenseUrl: String
  })

  const videoRef = ref(null)
  const videoContainer = ref(null)
  let player = null
  let ui = null

  onMounted(() => {
    if (shaka.Player.isBrowserSupported()) {
      initPlayer()
    } else {
      console.error('Shaka Player not supported on this browser.')
    }
  })

  onBeforeUnmount(() => {
    if (player) {
      player.destroy()
    }
  })

  function initPlayer() {
    const video = videoRef.value
    const container = videoContainer.value

    // Set up player and UI
    player = new shaka.Player(video)
    ui = new shaka.ui.Overlay(player, container, video)

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
      overflowMenuButtons: ['captions', 'quality', 'language', 'playback_rate']
    }

    ui.configure(uiConfig)
    const controls = ui.getControls()

    player.addEventListener('error', onErrorEvent)

    // === DRM Handling ===
    if (props.isDrm && props.licenseUrl && props.licenseToken) {
      // Register license request header via NetworkingEngine
      const netEngine = player.getNetworkingEngine()
      if (netEngine) {
        netEngine.registerRequestFilter((type, request) => {
          if (type === shaka.net.NetworkingEngine.RequestType.LICENSE) {
            request.headers['X-AxDRM-Message'] = props.licenseToken
          }
        })
      }

      player.configure({
        drm: {
          servers: {
            'com.widevine.alpha': props.licenseUrl
          }
        }
      })
    }

    // === Load the video ===
    if (props.videoUrl) {
      console.log('Attempting to play:', props.videoUrl)
      console.log('its token:', props.licenseToken)
      player
        .load(props.videoUrl)
        .then(() => console.log('[ShakaPlayer] Video loaded successfully'))
        .catch(onError)
    }
  }

  function onErrorEvent(event) {
    onError(event.detail)
  }
  function onError(error) {
    console.error('[ShakaPlayer] Error', error.code, error)
  }
  </script>

  <style scoped>
  .shaka-video {
    border-radius: 0.5rem;
  }
  </style>
