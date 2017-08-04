<div id="sermon-view">
  <div class="container">
    <div id="audio-page-container">
      <h1 class="audio-title"><?php echo $this->content->getTitle();?></h1>
      <div id="audio-player-container">
        <div data-audio-url="<?php echo $this->content->getAudioUrlPath();?>" data-audio-thumb="<?php echo $this->content->getThumbnailUrlPath();?>" id="audio-player" >
          Loading the player...
        </div>
      </div>
      <div id="waveform"></div>
      <div style="text-align: center">
        <button id="wav-play-btn" class="btn btn-primary">
          <i class="glyphicon glyphicon-play"></i>
          Play
        </button>
      </div>      
      <script type="text/javascript">
          $(document).ready(function(){
              var url = $('#audio-player').data("audio-url");
              var thumb = $('#audio-player').data("audio-thumb");
              jwplayer('audio-player').setup({
                  file: url,
                  image: thumb,
                  aspectratio: "16:9",
                  width: "100%",
                  "stretching": "fill",
                  autostart: true,
                  primary: 'HTML5',
                  controlbar:"bottom"
              });
              var wavesurfer = WaveSurfer.create({
                container: '#waveform',
                waveColor: 'violet',
                progressColor: 'purple'
              }); 
              wavesurfer.load(url); 
              $('#wav-play-btn').on('click',function(){
                console.log('clicking');
                wavesurfer.playPause();
              });
          });
        
      </script>
      <div class="row">
        [othercontent contenttype='audio' records='6' view='AudioBundle:Audio:get_audio_list' excludeids='<?php echo $this->content->getId();?>']
      </div>
    </div>
  </div>
</div>