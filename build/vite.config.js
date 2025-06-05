import {defineConfig} from 'vite'
import * as globModule from 'glob';
import path from 'path';

export default defineConfig(({ mode }) => ({
    plugins: [],
    build: {
        rollupOptions: {
            input: globModule.sync('mappings/**/*.{js,css}'),
            output: {
                entryFileNames: (chunkInfo) => {
                    if (chunkInfo.facadeModuleId) {
                        // Normalize path separators to "/"
                        const normalizedId = chunkInfo.facadeModuleId.replace(/\\/g, '/');
                        // Find the part after "/build/"
                        const match = normalizedId.match(/\/mappings\/(.+)$/);
                        if (match && match[1]) {
                            // Remove .js extension if you want, or leave as is
                            // For example, to keep the original extension:
                            return match[1];
                            // If you want to force .js extension:
                            // return match[1].replace(/\.[^/.]+$/, ".js");
                        }
                    }
                    // Fallback if not matched
                    return '[name].js';
                },
                chunkFileNames: '[name].js',
                assetFileNames: (assetInfo) => {
                    // Only rewrite for CSS files emitted as assets
                    if (assetInfo.name && assetInfo.name.endsWith('.css')) {
                        // Try to find the original source path in the mappings directory
                        // assetInfo.name is just the filename, so we need to find its corresponding entry
                        // Try to find a matching file in the input list
                        const orig = globModule.sync('mappings/**/*.css').find(f => path.basename(f) === assetInfo.name);
                        if (orig) {
                            // Get the path after mappings/
                            return orig.replace(/.*mappings[\\/]/, '');
                        }
                    }
                    // Fallback for other assets
                    return '[name][extname]';
                },
            },
        },
        sourcemap: 'inline',
        minify: true,
        outDir: '../dn-utilities/assets',
        emptyOutDir: true,
    }
}))