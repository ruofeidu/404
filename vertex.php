<script type="x-shader/x-vertex" id="vertex_shader">
uniform vec3 iResolution; // viewport resolution (in pixels)
varying vec2 fragCoord, vUv;

void main() {
    vUv = uv;
	fragCoord = vec2(uv.x * iResolution.x, uv.y * iResolution.y);
	gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
}
</script>