import js from '@eslint/js';

export default [
	{
		ignores: [
			'assets/dist/**',
			'node_modules/**',
			'release/**',
			'vendor/**',
		],
	},

	js.configs.recommended,

	{
		files: [
			'assets/scripts/**/*.js',
		],

		languageOptions: {
			ecmaVersion: 'latest',
			sourceType: 'module',

			globals: {
				window: 'readonly',
				document: 'readonly',
				history: 'readonly',
				setTimeout: 'readonly',
				jQuery: 'readonly',
			},
		},
	},
];