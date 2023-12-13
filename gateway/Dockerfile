#FROM maven:3.8.4-openjdk-11-slim AS build
FROM openjdk:17
EXPOSE 8076
ADD target/GateWay-0.0.1-SNAPSHOT.jar GateWay-0.0.1-SNAPSHOT.jar
ENTRYPOINT ["java", "-jar", "GateWay-0.0.1-SNAPSHOT.jar"]
