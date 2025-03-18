#!/bin/bash

# Copy JavaScript from src to public
cp src/assets/js/script.js public/assets/js/script.js

# Build Tailwind CSS using Yarn script
yarn run build:css

echo "Build complete!"
