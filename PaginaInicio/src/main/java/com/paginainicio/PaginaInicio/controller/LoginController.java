package com.paginainicio.PaginaInicio.controller;

import com.paginainicio.PaginaInicio.model.Usuario;
import com.paginainicio.PaginaInicio.repository.UsuarioRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

@Controller
public class LoginController {

    @Autowired
    private UsuarioRepository usuarioRepository;

    @GetMapping("/login")
    public String mostrarLogin() {
        return "login";  // Asegúrate de que tu archivo HTML se llama login.html
    }

    @PostMapping("/login")
    public String procesarLogin(@RequestParam String cuenta,
                                @RequestParam String contrasena,
                                Model model) {
        Usuario usuario = usuarioRepository.findByCuentaAndContrasena(cuenta, contrasena);

        if (usuario != null) {
            model.addAttribute("usuario", usuario);
            return "bienvenido";  // Crea una página bienvenido.html
        } else {
            model.addAttribute("error", "Cuenta o contraseña incorrecta.");
            return "login";
        }
    }
}
