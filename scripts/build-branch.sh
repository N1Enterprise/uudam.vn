#!/bin/sh

generate_build_version() {
    #!/bin/bash

    # Read the current version from .env
    CURRENT_VERSION=$(grep "BUILD_VERSION" .env | cut -d '=' -f2)

    # Split the version into an array of integers
    IFS='.' read -ra VERSION_PARTS <<< "$CURRENT_VERSION"

    # Increment the version logic
    if [ "${VERSION_PARTS[2]}" -lt 9 ]; then
        VERSION_PARTS[2]=$((VERSION_PARTS[2] + 1))
    elif [ "${VERSION_PARTS[1]}" -lt 9 ]; then
        VERSION_PARTS[1]=$((VERSION_PARTS[1] + 1))
        VERSION_PARTS[2]=0
    else
        VERSION_PARTS[0]=$((VERSION_PARTS[0] + 1))
        VERSION_PARTS[1]=0
        VERSION_PARTS[2]=0
    fi

    # Format the new version
    NEW_VERSION=$(IFS='.'; echo "${VERSION_PARTS[*]}")

    # Update .env with the new version
    awk -v current_version="$CURRENT_VERSION" -v new_version="$NEW_VERSION" \
        '{sub("BUILD_VERSION=" current_version, "BUILD_VERSION=" new_version)} 1' .env > .env_temp && \
        mv .env_temp .env

    # Display the new version
    echo "========== New Build Version: $NEW_VERSION =========="
}

git pull

php artisan optimize:clear

composer install
npm install
npm run prod:fe

generate_build_version

php artisan migrate --force

echo "========== Nice Done! =========="
