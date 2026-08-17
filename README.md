<div align="center">
    <img src="https://ctrlpanel.gg/img/controlpanel.png" width="128" alt="" />
</div>

# Archivos modificados — PbtHosting CtrlPanel

## Resumen

Estos son los archivos que hemos modificado durante los cambios realizados en el entorno local.

### 1. `app/Http/Controllers/ServerController.php`

Cambios relacionados con:

* Corrección del error 500 al consultar información de Pterodactyl (Fork).
* Manejo de servidores que todavía no tienen `pterodactyl_id`.
* Creación de servidores mediante `ServerCreationService`.
* Protección contra múltiples solicitudes de creación simultáneas.
* Validación de producto, créditos, recursos y allocations.
* Manejo de errores durante la creación.
* Eliminación de servidores.
* Manejo de errores de Pterodactyl (Fork).
* Mejoras en la obtención de información de los servidores.

### 2. `app/Services/ServerCreationService.php`

Cambios relacionados con:

* Creación del registro local del servidor.
* Generación/asignación del ID local.
* Reserva de créditos antes del aprovisionamiento.
* Obtención de Node y allocation disponibles.
* Creación del servidor en Pterodactyl (Fork).
* Guardado de `pterodactyl_id` e `identifier`.
* Estados de provisioning.
* Manejo de creación correcta.
* Manejo de creación fallida.
* Reembolso de créditos cuando corresponde.
* Reconciliación de estados inciertos.
* Protección contra solicitudes simultáneas mediante locks.

### 3. `app/Classes/PterodactylClient.php`

Cambios relacionados con:

* Comunicación con la API de Pterodactyl (Fork).
* Creación de servidores.
* Obtención de allocations.
* Obtención de información de servidores.
* Comprobación de recursos de Nodes.
* Manejo de respuestas y errores de Pterodactyl (Fork).

### 4. `app/Models/Server.php`

Cambios relacionados con:

* Generación automática del ID local mediante Nanoid.
* Estados del servidor:

  * `provisioning`
  * `active`
  * `failed`
  * `pending_reconciliation`
* Gestión de eliminación del servidor en Pterodactyl (Fork).
* Gestión del `pterodactyl_id`.
* Relaciones del servidor.

> **Importante:** este modelo no contiene `node_id` y no debemos añadirlo sin comprobar primero cómo funciona el modelo de Nodes del proyecto.

### 5. `app/Jobs/PostServerCreationJob.php`

Responsable de:

* Procesar las tareas posteriores a una creación correcta.
* Mantener el proceso de creación idempotente.
* Completar la configuración del servidor después de crearlo en Pterodactyl (Fork).

### 6. `app/Jobs/ReconcileServerCreationJob.php`

Responsable de:

* Comprobar servidores cuya creación quedó en un estado incierto.
* Determinar si Pterodactyl (Fork) creó realmente el servidor.
* Recuperar `pterodactyl_id` e `identifier` cuando sea posible.
* Evitar servidores locales inconsistentes.
* Gestionar correctamente créditos y estados pendientes.

### 7. `database/migrations/2026_08_17_084917_add_node_id_to_servers_table.php`

Migration relacionada con:

* Añadir la columna `node_id` a la tabla `servers`.
* Permitir almacenar el Node asociado al servidor.
* Preparar la base de datos para poder trabajar con la relación servidor → Node.

## Estructura

```text
app/
├── Classes/
│   └── PterodactylClient.php
├── Http/
│   └── Controllers/
│       └── ServerController.php
├── Jobs/
│   ├── PostServerCreationJob.php
│   └── ReconcileServerCreationJob.php
├── Models/
│   └── Server.php
└── Services/
    └── ServerCreationService.php

database/
└── migrations/
    └── 2026_08_17_084917_add_node_id_to_servers_table.php
```

## Pendiente

Antes de realizar modificaciones adicionales, comprobar:

* Si se modificó la estructura de la tabla `servers`.
* Si es necesario añadir/modificar `status`.
* Si existe alguna migration relacionada con los nuevos estados.
* Cómo se obtiene el Node en la versión actual del proyecto.
* Compatibilidad con **Jexpanel/Jexactyl**.
* Compatibilidad con **Pterodactyl (Fork)**.
* Revisar por qué los servidores no aparecen actualmente en `/servers`.
* Comprobar la relación entre los servidores almacenados en CtrlPanel y los servidores existentes en Pterodactyl (Fork).

# CtrlPanel.gg

CtrlPanel offers an easy-to-use and free billing solution for all starting and experienced hosting providers that seamlessly integrates with the Pterodactyl panel. It facilitates account creation, server ordering, and management, while offering addons, multiple payment methods, and customizable themes for a comprehensive solution.

> **Important:** CtrlPanel is **only compatible with Pterodactyl**. It does not support Pelican or any other hosting panels.

![GitHub tag](https://img.shields.io/github/tag/Ctrlpanel-gg/panel)
![Overall Installations](https://img.shields.io/badge/Overall%20Installations-8000%2B-green)
![GitHub stars](https://img.shields.io/github/stars/Ctrlpanel-gg/panel)
![License](https://img.shields.io/github/license/Ctrlpanel-gg/panel)
![Discord](https://img.shields.io/discord/787829714483019826)

![CtrlPanel](https://user-images.githubusercontent.com/67899387/214684708-739c1d21-06e8-4dec-a4f1-81533a46cc7e.png)

## Features

- Store with Credit-based system
- Popular payment gateways: PayPal, Stripe, Mollie, MercadoPago and more via thirdparty extensions
- Dynamic server billing (From hourly to yearly billing cycles)
- Referral and partner system
- Vouchers
- Ticket system
- Discord integration for verification and role assignment
- Role system with granular permissions
- Invoice generation with email delivery
- One account per IP registration limit
- HTTP API

And that's not all! Install CtrlPanel and you will be able to test all the available features that is being improved from version to version.

## Live Demo

Demo server: [demo.CtrlPanel.gg](https://demo.CtrlPanel.gg)

*Temporary demo - all data is periodically wiped.*

## Installation

Full installation documentation is available at [ctrlpanel.gg/docs](https://ctrlpanel.gg/docs/).

### Docker

> **Beta:** Docker support is experimental and not officially documented. Functionality is not guaranteed. Improvements are planned for a future release.

```bash
docker run -d -p 8080:80 -p 8443:443 --name ctrlpanel ghcr.io/ctrlpanel-gg/panel:latest
```

After starting, configure the database and Pterodactyl connection manually. See [.github/docker/README.md](https://github.com/Ctrlpanel-gg/panel/blob/main/.github/docker/README.md) for what's currently available.

### Linux

Supported on major distributions - Debian, Ubuntu, CentOS, Fedora, Arch, and others. Follow the [documentation](https://ctrlpanel.gg/docs/) for a full setup guide.

## Updating

See the [update instructions](https://ctrlpanel.gg/docs/category/updating) before upgrading.

## Marketplace

Looking for addons and extensions? Visit the [CtrlPanel Marketplace](https://market.ctrlpanel.gg/).

## Roadmap

Planned features and upcoming work: [CtrlPanel Roadmap](https://github.com/orgs/Ctrlpanel-gg/projects/1)

## Community and Support

For questions and help, join the [CtrlPanel Discord](https://discord.gg/ctrlpanel-gg-787829714483019826).

If you find CtrlPanel useful, consider [supporting the project](https://ctrlpanel.gg/docs/contributing/donating).

## Contributing

Contributions are welcome. Please read the following before getting started:

- [CONTRIBUTING.md](https://github.com/Ctrlpanel-gg/panel/blob/development/.github/CONTRIBUTING.md) - contribution guidelines and pull request process
- [CODE_OF_CONDUCT.md](https://github.com/Ctrlpanel-gg/panel/blob/development/.github/CODE_OF_CONDUCT.md) - community standards
- [CONTRIBUTOR_LICENSE_AGREEMENT](https://github.com/Ctrlpanel-gg/panel/blob/development/CONTRIBUTOR_LICENSE_AGREEMENT) - required for all contributors
- [LICENSE](https://github.com/Ctrlpanel-gg/panel/blob/main/LICENSE) - project license

## Security

To report a vulnerability, please follow the process described in [SECURITY.md](https://github.com/Ctrlpanel-gg/panel/blob/development/.github/SECURITY.md). Do not open public issues for security-related matters.
