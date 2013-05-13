package {
	import flash.display.MovieClip;
	import flash.text.TextField;
	import flash.text.TextFormat;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.events.TimerEvent;
	import flash.media.Sound;
	import flash.media.SoundChannel;
	import flash.media.SoundTransform;
	import flash.media.SoundLoaderContext;
	import flash.net.URLRequest;
	import flash.utils.Timer;
	import flash.net.URLLoader;
	import flash.xml.XMLDocument;
	import flash.events.ErrorEvent;
	import flash.display.SimpleButton;
	import flash.geom.Rectangle;
	import flash.filters.GlowFilter;


	public class Mp3Player extends MovieClip {

		// track variables
		private var _channel:SoundChannel;
		private var _sound:Sound;
		private var _position:int;
		private var _length:int;
		private var _loaded:int;
		private var _total:int;
		private var _currentPosition:uint;
		private var _repeat:Boolean;
		private var buffer:SoundLoaderContext;

		// spectrum
		private var _spectrum:Spectrum;

		// xml variables
		var xmlFileLoc:String = "playlist.xml";
		private var urlLoader:URLLoader;
		private var cNodes:Array;
		private static  var data:XML;

		// application variables
		private var timer:Timer = new Timer(20);
		private var currentTrack:uint;
		private var isPlaying:Boolean;
		private var dragOn:Boolean;
		private var seekerBound:Rectangle;//for track scrubber
		private var volumeBound:Rectangle;//for volume scrubber
		private var panBound:Rectangle;//for panning
		private var isLoading:Boolean;
		private var glowOn:GlowFilter = new GlowFilter(0xffffff,1,5,5,2,2,false,false);
		private var glowOff:GlowFilter = new GlowFilter(0xffffff,0,5,5,2,2,false,false);

		public function Mp3Player() {

			buffer = new SoundLoaderContext(5000);
//
			// track seeker / scrubber
			seekerBound = new Rectangle(0,tBar.tBarKnob.y,tBar.tBarBg.width,0);// boundary so scrubber will stay within the tBarBg
			tBar.addEventListener(MouseEvent.MOUSE_DOWN, trackingOn);
			stage.addEventListener(MouseEvent.MOUSE_UP, trackingOff);

			// back and forward buttons
			btnForward.addEventListener(MouseEvent.CLICK, nextTrack);
			btnBack.addEventListener(MouseEvent.CLICK, prevTrack);

			// Create the Stop, Play and Pause buttons
			playPauseButton.addEventListener(MouseEvent.CLICK, togglePlay);
			btnStop.addEventListener(MouseEvent.CLICK, stopTrack);

			// _repeat button
			_repeat = false;
			btnRepeat.addEventListener(MouseEvent.CLICK, toggleRepeat);
			btnRepeat.addEventListener(MouseEvent.MOUSE_OVER, btnOver);
			btnRepeat.addEventListener(MouseEvent.MOUSE_OUT, btnOut);

			// initialize xml
			xmlLoader();

			// spectrum display
			_spectrum = new Spectrum();
			_spectrum.x = 2;
			_spectrum.y = 45;
			addChild(_spectrum);
			setChildIndex(_spectrum, 1);

			// Volume Controls
			volumeBound = new Rectangle(0,vBar.vBarKnob.y,vBar.vBarBg.width,0);// boundary so volume will stay within the vBarBg
			vBar.addEventListener(MouseEvent.MOUSE_DOWN, volumeMouseDown);
			vBar.vBarKnob.x = vBar.vBarBg.width;

			// Panning Controls
			panBound = new Rectangle(0,pBar.pBarKnob.y,pBar.pBarBg.width,0);// boundary so panning will stay within the pBarBg
			pBar.addEventListener(MouseEvent.MOUSE_DOWN, panMouseDown);
			pBar.pBarKnob.x = pBar.pBarBg.width / 2;

		}

		private function toggleRepeat(evt:Event):void {
			var format1:TextFormat = new TextFormat();
			format1.letterSpacing = 1;

			if (_repeat == false) {
				btnRepeat.txtRepeat.text = "REPEAT ON";
				_repeat = true;
			} else {
				btnRepeat.txtRepeat.text = "REPEAT OFF";
				_repeat = false;
			}
			btnRepeat.txtRepeat.setTextFormat(format1);

		}

		private function btnOver(evt:MouseEvent):void {
			btnRepeat.txtRepeat.filters = [glowOn];
		}
		private function btnOut(evt:MouseEvent):void {
			btnRepeat.txtRepeat.filters = [glowOff];
		}
		//stop playing
		private function stopTrack(evt:Event):void {
			_channel.stop();
			isPlaying = false;
			tBar.tBarKnob.x = 0;
			txtTime.text = "0:00";
			_currentPosition = 0;
		}
		// volume scrubber
		private function volumeMouseDown(evt:Event):void {
			vBar.vBarKnob.startDrag(true,volumeBound);
			vBar.vBarKnob.filters = [glowOn];
		}
		// pan scrubber
		private function panMouseDown(evt:Event):void {
			pBar.pBarKnob.startDrag(true,panBound);
			pBar.pBarKnob.filters = [glowOn];
		}
		// track scrubber
		private function trackingOn(evt:Event):void {
			tBar.tBarKnob.startDrag(true,seekerBound);
			dragOn = true;//prevents accidental clicks
			tBar.tBarKnob.filters = [glowOn];
		}
		// when mouse is up after clicking any scrubber
		private function trackingOff(evt:Event):void {

			if (evt.target.name == "playPauseButton") {
			} else {

				tBar.tBarKnob.stopDrag();
				vBar.vBarKnob.stopDrag();
				pBar.pBarKnob.stopDrag();

				tBar.tBarKnob.filters = [glowOff];
				vBar.vBarKnob.filters = [glowOff];
				pBar.pBarKnob.filters = [glowOff];

				if (isPlaying == true) {
					if (dragOn == true) {
						_channel.stop();
						_channel = _sound.play(_length / 100 * Math.floor(tBar.tBarKnob.x/(tBar.tBarBg.width)*100));
						dragOn = false;
					}
				} else {// if not playing
					dragOn = false;
					_currentPosition = _length / 100 * Math.floor(tBar.tBarKnob.x/(tBar.tBarBg.width)*100);
				}
			}
		}
		public function xmlLoader():void {
			var URL:String = xmlFileLoc;
			var urlRequest:URLRequest = new URLRequest(URL);
			urlLoader = new URLLoader();
			urlLoader.addEventListener("complete", onLoaded);
			urlLoader.addEventListener("ioerror", ifFailed);
			urlLoader.load(urlRequest);
		}
		private function onLoaded(event:Event):void {
			data = XML(urlLoader.data);
			parseData(data);

			// Starts playing on run
			isLoading = true;
			timer.addEventListener(TimerEvent.TIMER, onTimer);
			timer.start();
			currentTrack = 0;
			loadTrack(currentTrack,0);
			isPlaying = true;
		}
		private function ifFailed(errorEvent:ErrorEvent):void {
			txtDisplay.text = "XML Load Fail";
		}
		private function parseData(data:XML):void {
			var x2:XMLDocument = new XMLDocument ();
			x2.ignoreWhite = true;
			var list:String = data.toXMLString ();
			x2.parseXML(list);
			cNodes = x2.firstChild.childNodes;
		}
		private function nextTrack(evt:Event):void {

			if (isPlaying == false) {
				isPlaying = true;
			}
			currentTrack++;
			_channel.stop();

			if (currentTrack > cNodes.length - 1) {// if is the last track
				loadTrack(0,0);//play the first track
				currentTrack = 0;
			} else {// if its not the last track
				loadTrack(currentTrack,0);//play the next track
			}
		}
		private function prevTrack(evt:Event):void {
			if (isPlaying == false) {
				isPlaying = true;
			}
			_channel.stop();

			if (currentTrack == 0) {
				//if at first track, play last track
				loadTrack(cNodes.length - 1,0);
				currentTrack = cNodes.length - 1;
			} else {
				currentTrack--;
				loadTrack(currentTrack,0);
			}
		}
		public function loadTrack(i:uint,pos:int):void {
			var data:XML = Mp3Player.data;
			var _mp3:String = data.mp3[i].url;//mp3 is the tag name in the xml file
			_sound = new Sound(new URLRequest(_mp3), buffer);
			_sound.addEventListener(Event.ID3, onID3);
			_channel = _sound.play(pos);
		}

		private function togglePlay(evt:Event):void {

			// If playing, stop and save that position
			if (isPlaying == true) {
				_channel.stop();
				isPlaying = false;
				_currentPosition = _position;
			} else {
				// Else, start at the saved position
				_channel = _sound.play(_currentPosition);
				isPlaying = true;
			}

		}
		public function onID3(event:Event):void {
			// Display selected id3 tags in the text field
			if (_sound.id3.artist == null || _sound.id3.songName == null) {
				txtDisplay.text = "Unknown Artist - Unknown Title";
			} else if (_sound.id3.songName == "" && _sound.id3.artist == "") {
				txtDisplay.text = "Unknown Artist - Unknown Title";
			} else if (_sound.id3.artist == "") {
				txtDisplay.text = "Unknown Artist : " + _sound.id3.songName;
			} else if (_sound.id3.songName == "") {
				txtDisplay.text = _sound.id3.artist + " : Unknown Title";
			} else {
				txtDisplay.text = _sound.id3.artist + " : " + _sound.id3.songName;
			}
			if (txtDisplay.width <= txtDisplay.textWidth) {
				// scrolling ticker code here
			}
		}
		private function onTimer(event:TimerEvent):void {

			_channel.soundTransform = new SoundTransform(vBar.vBarKnob.x / vBar.vBarBg.width, -1 + 2 * (pBar.pBarKnob.x / pBar.pBarBg.width));

			_loaded = _sound.bytesLoaded;// loaded bytes
			_total = _sound.bytesTotal;// total bytes
			_length = _sound.length;// total _length of track in miliseconds

			// show loading %
			if (_loaded < _total) {
				txtLoaded.text = Math.floor(_loaded / _total *100).toString() + "%";
				isLoading = true;
			} else {
				txtLoaded.text = "";
				isLoading = false;
			}
			if (_total > 0) {// if mp3 is successfully loaded

				tBar.tBarLoad.width = 185 * _loaded / _total;
				tBar.tBarBg.width = 172 * _loaded / _total;
				seekerBound = new Rectangle(0,2.5,tBar.tBarLoad.width-12,0);// boundary so scrubber will stay within the tBarBg
				_position = _channel.position;// current position off track in miliseconds
				if (dragOn == true) {
					_position = _length * tBar.tBarKnob.x / tBar.tBarBg.width;
					updateTimeDisplay();
				} else {
					if (isPlaying == false) {
					} else {
						tBar.tBarKnob.x = tBar.tBarBg.width/100 * Math.floor(_position / _length*100);
						updateTimeDisplay();
					}
				}
				_spectrum.update();

				//end of track
				if (dragOn == true) {
				} else {
					if (isLoading == false) {
						if (Math.ceil(_position / 1000) >= Math.floor(_length / 1000) && isPlaying == true) {
							if (_repeat == true) {
								_channel.stop();
								loadTrack(currentTrack,0);
							} else {
								currentTrack++;
								_channel.stop();

								if (currentTrack > cNodes.length - 1) {
									//last track, play first track
									loadTrack(0,0);//comment away to default no action
									currentTrack = 0;
								} else {
									loadTrack(currentTrack,0);
								}
							}
						}
					}
				}
			} else {
				isLoading = true;
				txtTime.text = "0:00";
				txtDisplay.text = "Buffering..";
			}
		}
		private function updateTimeDisplay() {
			var minutes:Number = Math.floor(_position / 1000) / 60 >> 0;
			var seconds:Number = Math.floor(_position / 1000) % 60 >> 0;

			// track time display
			if ( seconds >= 0 && seconds < 10) {
				txtTime.text = minutes.toString() + ":0" + seconds.toString();
			} else {
				txtTime.text = minutes.toString() + ":" + seconds.toString();
			}
		}
	}
}