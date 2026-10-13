#!/usr/bin/env bash
# Quickstart script for the Allianz & Co WordPress theme.
# Usage:  ./init.sh
#
# Brings up the Docker stack, then prints out the URL and admin credentials.

set -e

CYAN='\033[0;36m'; GREEN='\033[0;32m'; BOLD='\033[1m'; RESET='\033[0m'

echo -e "${CYAN}${BOLD}==> Allianz & Co — bringing up WordPress + MariaDB${RESET}"

if ! command -v docker >/dev/null 2>&1; then
  echo "Docker is not installed. Install Docker Desktop: https://www.docker.com/"
  exit 1
fi

docker compose up -d

echo ""
echo -e "${GREEN}${BOLD}==> Stack is up!${RESET}"
echo ""
echo -e "  Site:        ${BOLD}http://localhost:8080${RESET}"
echo -e "  Admin:       ${BOLD}http://localhost:8080/wp-admin${RESET}"
echo -e "  Username:    ${BOLD}admin${RESET}"
echo -e "  Password:    ${BOLD}admin${RESET}"
echo -e "  phpMyAdmin:  ${BOLD}http://localhost:8081${RESET}"
echo ""
echo -e "${CYAN}Note: the theme is mounted as a read-only volume, so any"
echo -e "edit in wordpress-theme/allianzandco/ is reflected live.${RESET}"
echo ""
echo -e "${CYAN}To stop:${RESET}    docker compose down"
echo -e "${CYAN}To reset:${RESET}   docker compose down -v && ./init.sh"
