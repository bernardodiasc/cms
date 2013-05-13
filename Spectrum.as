package {
	import flash.display.Bitmap;
	import flash.display.BitmapData;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.filters.DropShadowFilter;
	import flash.geom.Rectangle;
	import flash.media.SoundMixer;
	import flash.utils.ByteArray;
	import flash.display.Stage;

	public class Spectrum extends Sprite {
		private var _spectrumBMP:BitmapData;
		private var _spectrumWidth:Number = 295;

		public function Spectrum() {
			// Bitmap to draw spectrum data in
			_spectrumBMP = new BitmapData(_spectrumWidth, 50, true, 0x00000000);//width, height, transp, fill
			var bitmap:Bitmap = new Bitmap(_spectrumBMP);
			addChild(bitmap);
		}
		public function update():void {
			// Get spectrum data
			var spectrum:ByteArray = new ByteArray();
			SoundMixer.computeSpectrum(spectrum);

			// Draw to bitmap
			_spectrumBMP.fillRect(_spectrumBMP.rect, 0x00000000);// spectrum rectangle
			_spectrumBMP.fillRect(new Rectangle(0, 0, _spectrumWidth, 0), 0x000000000);//spectrum background
			for (var i:int=0; i<_spectrumWidth; i++) {
				_spectrumBMP.setPixel32(i, 10 + spectrum.readFloat() * 20, 0xAAAAAAAA);//spectrum color
			}
		}
	}
}