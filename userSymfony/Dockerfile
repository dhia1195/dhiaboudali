FROM node:18
WORKDIR /app
COPY package*.json ./
COPY . .
RUN npm install
RUN npm run build
 CMD [ "node","ErrorsMakerPidev","-a","0.0.0.0","-p","4200"]