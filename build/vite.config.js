import { defineConfig } from 'vite'

const inputs = {
    adminJs: {
        'file': 'configs/admin/admin.js',
        'outFile': 'admin/js/dn-utilities-admin.js',
    },
    adminCss: {
        'file': 'configs/admin/admin.css',
        'outFile': 'admin/css/dn-utilities-admin.css',
    },
    commonJs: {
        'file': 'configs/common/common.js',
        'outFile': 'common/js/dn-utilities-common.js',
    }
}

const outputFiles = Object.fromEntries(
    Object.entries(inputs).map(([key, value]) => [key, value.outFile])
);

const inputFiles = Object.fromEntries(
    Object.entries(inputs).map(([key, value]) => [key, value.file])
);

export default defineConfig({
    plugins: [
    ],
    build: {
        rollupOptions: {
            input: inputFiles,
            output: {
                entryFileNames: (chunkInfo) => {
                    // chunkInfo.name is the key ("main", "admin", etc.)
                    const outFile = outputFiles[chunkInfo.name] || '';
                    return outFile ? outFile : '[name].js';
                },
                chunkFileNames: 'assets/[name].js',
                assetFileNames: (assetInfo) => {
                    // assetInfo.name will be e.g. "adminCss.css"
                    // Map assetInfo.name to the corresponding outFile
                    if (assetInfo.name && assetInfo.name.endsWith('.css')) {
                        const outFile = outputFiles[assetInfo.name.replace('.css', '')];
                        // fallback to just using the provided name if no mapping found
                        return outFile ? outFile : '[name][extname]';
                    }
                    // Default for other assets
                    return 'assets/[name][extname]';
                }
            },
        },
        sourcemap: 'inline',
        minify: true,
        outDir: '../dn-utilities/assets',
        emptyOutDir: true,
        watch: {
            include: '{configs,assets}/**/*.{css,js}' // watches additional files that are not in the rollupOptions.input list
        }
    }
})