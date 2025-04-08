package com.example.PaginaInicio.controller;

import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;


@Controller
public class HolaController {
    
    

    @GetMapping("/hello")
    public String login(Model model) {
        System.out.println("Funciona!!!");

        model.addAttribute("mensaje", "¡Hola mundo desde Spring Boot!");
        return "none"; // Thymeleaf buscará un archivo hola.html en src/main/resources/templates
    }


    
    

}
