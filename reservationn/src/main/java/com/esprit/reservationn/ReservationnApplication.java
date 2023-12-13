package com.esprit.reservationn;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cloud.client.discovery.EnableDiscoveryClient;

@SpringBootApplication
@EnableDiscoveryClient
public class ReservationnApplication {

	public static void main(String[] args) {
		SpringApplication.run(ReservationnApplication.class, args);
	}

}
