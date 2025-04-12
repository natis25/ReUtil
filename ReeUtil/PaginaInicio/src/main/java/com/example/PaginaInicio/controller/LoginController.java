package com.example.PaginaInicio.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;

import com.example.PaginaInicio.service.EmpleadoService;

import org.springframework.ui.Model;

@Controller
public class LoginController {
    @Autowired
    private EmpleadoService usuarioService;

    @GetMapping("/login")
    public String mostrarFormularioLogin() {
        return "InicioSesion"; // nombre del archivo HTML en /templates/login.html
    }

    @PostMapping("/login")
    public String procesarLogin(@RequestParam String correo,
            @RequestParam String contrasena,
            Model model) {

        boolean loginExitoso = usuarioService.validarInicioSesion(correo, contrasena);

        if (loginExitoso) {
            model.addAttribute("mensaje", "Inicio de sesión exitoso 🎉");
            return "index"; // Puedes redirigir a una página principal
        } else {
            model.addAttribute("error", "⚠️ Error al iniciar sesión. Verifica tus datos.");
            return "InicioSesion"; // vuelve al formulario
        }
    }

}
