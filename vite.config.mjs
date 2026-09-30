import { defineConfig } from 'vite';
import { resolve } from 'node:path';

export default defineConfig({
	base: './',

	css: {
		lightningcss: {
			errorRecovery: true,
		},
	},

	build: {
		outDir: resolve(
			process.cwd(),
			'assets/dist'
		),

		emptyOutDir: true,
		sourcemap: false,
		target: 'es2018',

		lib: {
			entry: resolve(
				process.cwd(),
				'assets/scripts/src/main.js'
			),

			name: 'WebsiteNITheme',
			formats: ['iife'],

			fileName: () => 'script.js',
			cssFileName: 'style',
		},

		/**
		 * Use WordPress's jQuery rather than
		 * bundling another copy.
		 */
		rolldownOptions: {
			external: [
				'jquery',
			],

			output: {
				globals: {
					jquery: 'jQuery',
				},
			},
		},
	},
});