<!DOCTYPE html>
<html>
<head>
    <title>WebRTC Reference App</title>

    <meta http-equiv="X-UA-Compatible" content="chrome=1"/>

    <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
    <script src="<?= $GLOBALS['sr_root'] ?>/js/adapter.js"></script>
    <script src="<?= $GLOBALS['sr_root'] ?>/js/main.js"></script>

    <link rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/main.css">
</head>

<body>
<script type="text/javascript">
var sessionToken = '<?= $context['session']->generate_token() ?>';
var sessionId = '<?= $context['session']->id ?>';
var participantId = '<?= $context['participant']->id ?>';
var roomLink = '<?= $context['room_link'] ?>';
var initiator = <?= $context['initiator'] ?>;
var pcConfig = {"iceServers": [{"url": "stun:stun.l.google.com:19302"}]};
var pcConstraints = {"optional": [{"DtlsSrtpKeyAgreement": true}]};
var offerConstraints = {"optional": [], "mandatory": {}};
var mediaConstraints = {"audio": true, "video": {"mandatory": {}, "optional": []}};
var stereo = false;
var roomName = '<?= $context['session']->name ?>';
var userName = '<?= $context['participant']->name ?>';
var userId = '<?= $context['participant']->user_id ?>';
var isRegisteredUser = 0;

setTimeout(initialize, 1);

</script>

<div id="container" ondblclick="enterFullScreen()"> 
  <div id="card">
    <div id="local">
      <video id="localVideo" autoplay="autoplay" muted="true"/>
    </div>
    <div id="remote">
      <video id="remoteVideo" autoplay="autoplay">
      </video>
      <div id="mini">
        <video id="miniVideo" autoplay="autoplay" muted="true"/>
      </div>
    </div>
  </div>
</div>

</body>

<!--footer id="footer">
</footer-->

</html>
