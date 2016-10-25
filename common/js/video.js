var video_count = 0; 

function SVVideo (src) {
    this.src = src;
	
	
	this.video = document.createElement( 'video' );
	this.video.src = src;
	this.video.style.width = '31%';
	this.video.style.height = '100%';
	this.video.style.padding = '1%';
	this.video.loop = true; 
	this.video.load(); // must call after setting/changing source
	this.video.play();
	
    this.image = document.createElement( 'canvas' );
	this.image.width = 1280;
	this.image.height = 720;
	
	this.context = this.image.getContext( '2d' );
	this.context.fillRect( 0, 0, this.image.width, this.image.height );
	this.context.fillStyle = '#000000';
	
	this.texture = new THREE.Texture( this.image );
	this.texture.minFilter = THREE.LinearFilter;
	this.texture.magFilter = THREE.LinearFilter;
	
	// this.material = new THREE.MeshBasicMaterial( { map: this.texture, overdraw: true, side:THREE.DoubleSide } );
	// this.geometry = new THREE.PlaneGeometry( settings.width, settings.height, 4, 4 );
	
	// this.mesh = new THREE.Mesh( this.geometry, this.material );
	// this.mesh.position.set(0, settings.height / 2, 0);
	
	// scene.add(this.mesh);
	// this.mesh.visible = false; 
}

var videos = []; 


