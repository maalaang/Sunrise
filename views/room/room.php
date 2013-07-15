<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?= $GLOBALS['sr_root'] ?>/js/adapter.js"></script>
        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/default.css">
    </head>
    <body>
        <script type="text/javascript">
            var localVideo;
            var miniVideo;
            var remoteVideo;
            var localVideoCnt = 0;
            var localStream;

            function initialize() {
                console.log("initialize");
                localVideo = document.getElementById('localVideo');
                doGetUserMedia();
            }

            function doGetUserMedia() {
                var constraints = {"audio": true, "video": {"mandatory": {}, "optional": []}}; 
                try {
                    getUserMedia(constraints, onUserMediaSuccess, onUserMediaError);
                    console.log("Requested access to local media with mediaConstraints:\n  \"" + JSON.stringify(constraints) + "\"");
                } catch (e) {
                    alert("getUserMedia() failed. Is this a WebRTC capable browser?");
                    console.log("getUserMedia failed with exception: " + e.message);
                }
            }

            function onUserMediaSuccess(stream) {
                console.log("User has granted access to local media.");

                attachMediaStream(localVideo, stream);
                localVideo.style.opacity = 1;
                localStream = stream;

//                if (initiator) maybeStart();
            }

            function onUserMediaError(error) {
                console.log("Failed to get access to local media. Error code was " + error.code);
                alert("Failed to get access to local media. Error code was " + error.code + ".");
            }

            function doAddLocalVideo() {
                if (localStream == null) {
                    console.log("Local stream has not been initialized.");
                    return;
                }

                localVideoCnt++;
                
                var subVideo = $('#subVideo');
                var html = subVideo.html();

                html += '<video id="localVideo' + localVideoCnt + '" class="subVideo" autoplay="autoplay" muted="true"/>';
                subVideo.html(html);

                var addedVideo = document.getElementById('localVideo' + localVideoCnt);

                attachMediaStream(addedVideo, localStream);
                addedVideo.style.opacity = 1;
            }

            $(document).ready(function() {
                initialize();
            });

        </script>
        <div>
            <p>maalaang-WebRTC (in development)</p>
        </div>
        <div id="leftPanel">
            <div>
                <span>Add Screen: </span><input type="button" value="Add" onclick="doAddLocalVideo();" />
            </div>
        </div>
        <div id="mainPanel">
            <div id="card">
                <div id="mainVideo">
                    <video id="localVideo" autoplay="autoplay" muted="true"/>
                </div>
                <div id="subVideo">
                </div>
            </div>
            <div id="footer">
            </div>
        </div>
    </body>
</html>
