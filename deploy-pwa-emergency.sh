#!/bin/bash

echo "🚀 DHI PWA Emergency Deployment Script"
echo "======================================="
echo ""

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Step 1: Pulling latest changes...${NC}"
git pull origin master
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Git pull successful${NC}"
else
    echo -e "${RED}❌ Git pull failed${NC}"
    exit 1
fi

echo ""
echo -e "${YELLOW}Step 2: Clearing Laravel caches...${NC}"
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

echo ""
echo -e "${YELLOW}Step 3: Testing critical routes...${NC}"

# Test manifest route
echo -e "Testing manifest route..."
MANIFEST_STATUS=$(curl -s -o /dev/null -w "%{http_code}" "$(php artisan route:list | grep manifest | awk '{print $4}' | head -1)")
if [ "$MANIFEST_STATUS" = "200" ]; then
    echo -e "${GREEN}✅ Manifest route working (HTTP $MANIFEST_STATUS)${NC}"
else
    echo -e "${RED}❌ Manifest route failed (HTTP $MANIFEST_STATUS)${NC}"
fi

# Test manifest link in HTML
echo -e "Testing manifest link in homepage..."
MANIFEST_LINK=$(curl -s "$(php artisan route:list | grep 'home' | awk '{print $4}' | head -1)" | grep -i "manifest")
if [ ! -z "$MANIFEST_LINK" ]; then
    echo -e "${GREEN}✅ Manifest link found in HTML${NC}"
    echo "   $MANIFEST_LINK"
else
    echo -e "${RED}❌ Manifest link NOT found in HTML${NC}"
fi

echo ""
echo -e "${YELLOW}Step 4: PWA Debug URLs:${NC}"
echo "🔍 PWA Debug: https://dhiegypt.com/pwa-debug.html"
echo "📊 Diagnostic: https://dhiegypt.com/diagnostic.php" 
echo "📄 Manifest: https://dhiegypt.com/manifest.json"
echo "🏠 Homepage: https://dhiegypt.com/ar/"

echo ""
echo -e "${GREEN}🎉 Deployment completed!${NC}"
echo ""
echo -e "${YELLOW}Next steps:${NC}"
echo "1. Test PWA debug tool: https://dhiegypt.com/pwa-debug.html"
echo "2. Clear browser cache and test install prompt"
echo "3. Try incognito/private browsing mode"
echo ""