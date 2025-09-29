# MobbiSaúde ♿

**Conectando Cuidado e Comunidade através do Compartilhamento de Equipamentos de Saúde.**

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![Livewire](https://img.shields.io/badge/Livewire-3.x-4E57E8?style=for-the-badge&logo=livewire)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-06B6D4?style=for-the-badge&logo=tailwindcss)
![Alpine JS](https://img.shields.io/badge/Alpine_JS-3.x-8BC0D0?style=for-the-badge&logo=alpine.js)
![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge&logo=php)

---

## 🎓 Sobre o Projeto

**MobbiSaúde** é uma plataforma web desenvolvida como **Trabalho de Graduação (TG)** para o curso de Análise e Desenvolvimento de Sistemas da **FATEC Jales - Prof. José Camargo**. O projeto foi idealizado e desenvolvido pelos alunos **Igor Gabriel Vinturini** e **João Pedro Merlotti**.

O propósito central da plataforma é criar um ecossistema solidário para o empréstimo e locação de equipamentos de saúde (como cadeiras de rodas, camas hospitalares, muletas, etc.). A aplicação visa conectar pessoas que possuem equipamentos ociosos com aquelas que necessitam de uso temporário, promovendo a acessibilidade, a economia circular e o apoio mútuo na comunidade.

Inicialmente, o sistema opera com foco em empréstimos gratuitos, fortalecendo o laço comunitário, com uma estrutura contratual robusta para garantir a segurança e a responsabilidade de ambas as partes.

## ✨ Principais Funcionalidades

* **🔐 Autenticação Segura:** Sistema completo de login, registro e recuperação de senha, com funcionalidade "Lembrar de Mim".
* **👤 Gestão de Perfil:** Os usuários podem gerenciar suas informações pessoais, endereço, documentos e foto de perfil (avatar).
* **🛠️ Gestão de Equipamentos:** Usuários logados podem cadastrar, editar e remover seus próprios equipamentos, incluindo múltiplas imagens e categorização por tipo.
* **🔍 Busca e Navegação:** Interface pública para que visitantes possam navegar e buscar por tipos de equipamentos disponíveis na plataforma.
* **📄 Sistema de Contratos:** Fluxo completo para a geração e aceite de contratos de empréstimo, exigindo o consentimento de ambas as partes (locador e locatário) para garantir a segurança da transação.
* **🔒 URLs Seguras:** Utilização de UUIDs (`public_id`) nas URLs para evitar a exposição de IDs sequenciais e proteger a privacidade dos dados.
* **📱 Interface Responsiva:** O layout se adapta perfeitamente a dispositivos móveis, tablets e desktops.

## 🚀 Tecnologias Utilizadas (Tech Stack)

Este projeto foi construído utilizando a filosofia **TALL Stack**, que privilegia a produtividade e a criação de interfaces dinâmicas com o conforto do PHP no back-end.

* **Back-end:**
    * [**PHP 8.4+**](https://www.php.net/)
    * [**Laravel 12**](https://laravel.com/): O framework PHP robusto e elegante que serve como espinha dorsal da aplicação.
* **Front-end & UI:**
    * [**Livewire 3**](https://livewire.laravel.com/): Para a criação de interfaces dinâmicas e reativas sem sair do PHP.
    * [**Alpine.js**](https://alpinejs.dev/): Para interatividade leve no front-end quando necessário.
    * [**Tailwind CSS**](https://tailwindcss.com/): Um framework CSS utility-first para a criação de designs modernos e customizáveis.
* **Banco de Dados:**
    * Compatível com MySQL / PostgreSQL.
* **Gerenciamento de Mídias:**
    * [**Spatie Media Library**](https://spatie.be/docs/laravel-medialibrary/v11/introduction): Pacote robusto para associação de arquivos (imagens de equipamentos, avatares) aos models Eloquent.
* **Ambiente de Desenvolvimento:**
    * [**Laravel Sail**](https://laravel.com/docs/12.x/sail): Ambiente de desenvolvimento Docker para uma configuração rápida e consistente.
    * [**MinIO**](https://min.io/): Armazenamento de objetos local compatível com a API do S3 da AWS.

## ⚙️ Instalação e Configuração

Siga os passos abaixo para executar o projeto em seu ambiente local.

1.  **Clone o repositório:**
    ```bash
    git clone [https://github.com/seu-usuario/mobbisaude.git](https://github.com/seu-usuario/mobbisaude.git)
    cd mobbisaude
    ```

2.  **Instale as dependências do Composer:**
    ```bash
    composer install
    ```

3.  **Copie o arquivo de ambiente:**
    ```bash
    cp .env.example .env
    ```

4.  **Gere a chave da aplicação:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure seu arquivo `.env`:**
    * Ajuste as credenciais do banco de dados (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
    * Configure as variáveis para o MinIO/S3 se for usar armazenamento de arquivos local.

6.  **Execute as migrations do banco de dados:**
    ```bash
    php artisan migrate
    ```

7.  **Crie o link simbólico para o armazenamento:**
    ```bash
    php artisan storage:link
    ```

8.  **Instale as dependências do NPM e compile os assets:**
    ```bash
    npm install
    npm run dev
    ```

9.  **Inicie o servidor de desenvolvimento:**
    ```bash
    php artisan serve
    ```

Pronto! A aplicação estará rodando em `http://127.0.0.1:8000`.

## ✍️ Autores

| Nome                    | GitHub                               |
| ----------------------- | ------------------------------------ |
| **Igor Gabriel Vinturini** | `[Link para o GitHub do Igor]`       |
| **João Pedro Merlotti** | [jpmerlotti](https://github.com/jpmerlotti) |

Trabalho de Graduação apresentado à **[FATEC Jales](https://www.fatecjales.edu.br/)** como requisito parcial para obtenção do título de Tecnólogo em Análise e Desenvolvimento de Sistemas.

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE.md) para mais detalhes.