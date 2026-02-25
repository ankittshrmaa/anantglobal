# Anant Global Immigartion.

This is a side web-project made on the request of my friend who own this site hosted on anantglobal.in
One of my freind who is working in a immigartion sector, he starts his own immigartion centre and ask me for creating a website for him
so i created this website: its a simple website just o let user interact with and business purpose.

# How i build this.

I use HTML, CSS and java-script in this website.
Hosted on a physical ubuntu server using nginx.
For contact use API to connect with whatsapp and we get email notification if any user click on contact us..
Use cloutflare as to host this website

# Workflow.

## For WSL: Physical Ubuntu Server-----> Nginx----->CloudFlare----->Web-search.
## For AWS- Hosting:
[ User Browser ]
        |
        | 1. DNS Query
        v
[ Cloudflare DNS ]
        |
        | 2. HTTPS (TLS terminates here)
        v
[ Cloudflare Edge (WAF + CDN + Reverse Proxy) ]
        |
        | 3. Encrypted persistent tunnel (outbound from server)
        v
[ cloudflared Agent running on EC2 ]
        |
        | 4. Local HTTP
        v
[ Nginx :80 ]
        |
        v
[ Website files /var/www/html ]

