export function iePolyfill() {
	//only IE has no support for svgforeignobject
	if(!Modernizr.svgforeignobject) {
		const iconBlocks = document.querySelectorAll('.shp-icon--block');
		if(iconBlocks.length) {

			// IE 11 compatible loop => https://developer.mozilla.org/en-US/docs/Web/API/NodeList
			Array.prototype.forEach.call(iconBlocks, function (iconBlock) {
				let icon = iconBlock.getElementsByTagName("svg");

				if(icon) {
					icon = icon[0];
					const viewBox = (icon.getAttribute('viewBox')) ? (icon.getAttribute('viewBox').split(' ').length === 4) ? icon.getAttribute('viewBox').split(' ').map(Number) : false : false;
					const parentWidth = iconBlock.clientWidth;
					let fontSize = window.getComputedStyle(iconBlock, null).getPropertyValue('font-size');
					fontSize = (parseFloat(fontSize)) ? parseFloat(fontSize) : false;

					if(viewBox && parentWidth && fontSize) {
						const viewBoxWidth = viewBox[2];
						const viewBoxHeight = viewBox[3];

						const width = parentWidth / fontSize;
						const height = (parentWidth * viewBoxHeight / viewBoxWidth) / fontSize;

						icon.style.cssText = icon.style.cssText + 'width:' + width + 'em;height:' + height + 'em;';
					}
				}
			});
		}
	}
}