package com.example.PaginaInicio.controller;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;

@Controller
public class HolaController {

    @GetMapping("/login")
    public String hola(Model model) {
        model.addAttribute("mensaje", "¡Hola mundo desde Spring Boot!");
        return "InicioSesion"; // Thymeleaf buscará un archivo hola.html en src/main/resources/templates
    }
}
