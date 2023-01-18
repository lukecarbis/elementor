class ImageGenerationModule extends elementorModules.editor.utils.Module {
	onElementorInit() {
		elementor.channels.editor.on( 'elementor:generateImage', this.sendAPIRequest );
	}

	generateImage( sectionName ) {
		this.sendAPIRequest( sectionName );
	}

	sendAPIRequest( sectionName ) {
		const url = 'https://api.openai.com/v1/images/generations';
		const data = {
			prompt: 'A cute baby sea otter',
			n: 1,
			size: '1024x1024',
		};
		const headers = {
			Authorization: 'Bearer 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', // Elementor.settings.page.model.attributes.openai_api_key,
			'Content-Type': 'application/json',
		};
		fetch( url, { method: 'POST', headers, body: JSON.stringify( data ) } )
			.then( ( response ) => response.json() )
			.then( ( result ) => {
				console.log( result.data[ 0 ].url );
			} );
	}
}

export default ImageGenerationModule;
