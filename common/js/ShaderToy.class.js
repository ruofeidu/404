'use strict';

function ShaderToy(shaderName) {
	this.uniforms = {
		iGlobalTime: { type: "f", value: 0.0 },
		iResolution: { type: "v3", value: new THREE.Vector3() },
		iMouse: { type: "v4", value: new THREE.Vector4() }
	};
}