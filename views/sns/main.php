<script src="http://connect.facebook.net/en_US/all.js"></script>

<div id="fb-root"></div>

<script>
	window.fbAsyncInit = function() {

		FB.init({

			appId : '426582144117672',
			channelUrl : 'http://dev.maalaang.com/workspace/brownbear/Sunrise/d/sns/test/',
			status : true,
			xfbml : true

		});

		FB.getLoginStatus(function(response) {

			if (response.status === 'connected') {
				var uid = response.authResponse.userID;
				var accessToken = response.authResponse.accessToken;
				console.log(accessToken);
			} else if (response.status === 'not_authorized') {
				console.log('not_authorized');
			} else {
				console.log('no login');
			}
		});

		FB.login(function(response) {
			if (response.authResponse) {

				FB.api('/me', function(response) {
					console.log('Good to see you, ' + response.name + '.');
				});

				var body = 'Sunrise SNS_facebook Test ';
				FB.api('/me/feed', 'post', {
					message : body
				}, function(response) {
					if (!response || response.error) {
						console.log(response.error.code + ' ' + response.error.message);
					} else {

						console.log('Post ID: ' + response.id);
					}
				});
			} else {
			}
		});

		FB.login(function(response) {
			if (response.authResponse) {
				console.log('Welcome!  Fetching your information.... ');
				FB.api('/me', function(response) {
					console.log('Good to see you, ' + response.name + '.');
				});
			} else {
				console.log('User cancelled login or did not fully authorize.');

			}

		}, {
			scope : 'publish_stream'
		});

	};

</script>
