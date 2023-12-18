FROM node:18.18.0-alpine as angular
WORKDIR /app
COPY package*.json ./
COPY . .
RUN npm install --force
RUN npm run build
 CMD [ "npx","http-server","dist/argon-dashboard-angular","-a","0.0.0.0","-p","4200"]
#FROM nginx:alpine
#COPY --from=node /app/dist /usr/share/nginx/html