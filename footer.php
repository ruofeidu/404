<script>
var scene, camera, uniforms; 
var isMouseDown = false, mousePos = {x:window.innerWidth, y:0, z:0, w:0};
var start_time = new Date() / 1000;

document.onmousedown = function() { isMouseDown = true; mousePos.z = 1; mousePos.w = 1; };
document.onmouseup   = function() { isMouseDown = false; mousePos.z = 0; mousePos.w = 0;  };

function handleMouseMove(event) {
	if (isMouseDown) {
		var dot, eventDoc, doc, body, pageX, pageY;
		event = event || window.event; // IE-ism

		if (event.pageX == null && event.clientX != null) {
			eventDoc = (event.target && event.target.ownerDocument) || document;
			doc = eventDoc.documentElement;
			body = eventDoc.body;

			event.pageX = event.clientX +
			  (doc && doc.scrollLeft || body && body.scrollLeft || 0) -
			  (doc && doc.clientLeft || body && body.clientLeft || 0);
			event.pageY = event.clientY +
			  (doc && doc.scrollTop  || body && body.scrollTop  || 0) -
			  (doc && doc.clientTop  || body && body.clientTop  || 0 );
		}

		mousePos.x = event.pageX;
		mousePos.y = event.pageY;
	} else {
		
	}
}
	
function init() 
{
	scene = new THREE.Scene();
	var SCREEN_WIDTH = window.innerWidth, SCREEN_HEIGHT = window.innerHeight;
	var VIEW_ANGLE = 45; //Camera frustum vertical field of view, from bottom to top of view, in degrees.
	var ASPECT = SCREEN_WIDTH / SCREEN_HEIGHT;
	var	NEAR = 0.1, FAR = 20000;
	camera = new THREE.PerspectiveCamera( VIEW_ANGLE, ASPECT, NEAR, FAR);
	
	topCamera = new THREE.OrthographicCamera(
    window.innerWidth / -4,		// Left
    window.innerWidth / 4,		// Right
    window.innerHeight / 4,		// Top
    window.innerHeight / -4,	// Bottom
    -5000,            			// Near 
    10000 );           			// Far -- enough to see the skybox
	topCamera.up = new THREE.Vector3(0,0,-1);
	topCamera.lookAt( new THREE.Vector3(0,-1,0) );
	topCamera.aspect = window.innerWidth / window.innerHeight;
	topCamera.updateProjectionMatrix();
	scene.add(topCamera);
	
	renderer = new THREE.WebGLRenderer( {antialias:true} );
	renderer.setClearColor( 0x000000 );
	renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
	container = document.getElementById( 'GL' );
	container.appendChild( renderer.domElement );

	var stoneTexture = new THREE.ImageUtils.loadTexture( 'presets/tex19.png' );

	// FLOOR
	uniforms = {
		iChannel0: { type: "t", value: stoneTexture },
		iGlobalTime: { type: "f", value: 0.0 },
		iResolution: { type: "v3", value: new THREE.Vector3(window.innerWidth, window.innerHeight, 0) },
		iMouse: { type: "v4", value: new THREE.Vector4() }
	};
	
	var floorMaterial = new THREE.ShaderMaterial({
		uniforms: uniforms,
		overdraw: true,
		vertexShader: document.getElementById( 'vertex_shader' ).textContent,
		fragmentShader: document.getElementById( 'fragment_shader' ).textContent,
		side: THREE.DoubleSide,
		transparent: true,
	}); 
	
	var floorGeometry = new THREE.PlaneBufferGeometry(SCREEN_WIDTH/2, SCREEN_HEIGHT/2, 10, 10);
	var floor = new THREE.Mesh(floorGeometry, floorMaterial);
	floor.position.y = 0;
	floor.rotation.x = -Math.PI / 2;
	scene.add(floor);
}

function animate() {
    requestAnimationFrame( animate );
	// update all uniforms
	uniforms.iGlobalTime.value = new Date() / 1000 - start_time;
	uniforms.iResolution.value = new THREE.Vector3(window.innerWidth, window.innerHeight, 0);
	uniforms.iMouse.value = new THREE.Vector4(mousePos.x, mousePos.y, mousePos.z, mousePos.w);
	this.renderer.render( scene, topCamera );
}

init();
animate();

window.addEventListener('resize', onWindowResize, false);

function onWindowResize() {
	topCamera.aspect = window.innerWidth / window.innerHeight;
	topCamera.updateProjectionMatrix();

	renderer.setSize(window.innerWidth, window.innerHeight);
};

</script>
</body>
</html>