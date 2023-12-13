package com.esprit.chambre;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cloud.client.discovery.EnableDiscoveryClient;

@EnableDiscoveryClient
@SpringBootApplication
public class ChambreApplication {

	public static void main(String[] args) {
		SpringApplication.run(ChambreApplication.class, args);
	}

}
