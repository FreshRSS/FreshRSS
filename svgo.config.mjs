export default {
	js2svg: {
		indent: '\t',
		pretty: true,
		eol: 'lf',
		finalNewline: true,
	},
	multipass: true,
	plugins: [ // https://svgo.dev/docs/plugins/
		{
			name: 'preset-default', // Built-in plugins enabled by default: https://svgo.dev/docs/preset-default/#plugins-list
			params: {
				overrides: {
					// Disable selected plugins from the default preset
					removeComments: false,
				},
			},
		},

		// Extra plugins
		'removeScripts',
	],
};
