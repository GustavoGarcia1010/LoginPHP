# 🚀 Ultra Admin - Dashboard System

Este é um sistema de gerenciamento administrativo robusto desenvolvido em PHP, utilizando a arquitetura **MVC (Model-View-Controller)** para garantir uma organização clara, escalável e de fácil manutenção.

---

## 🏗️ Arquitetura do Projeto

O sistema segue os padrões modernos de desenvolvimento web, separando as responsabilidades em três camadas principais:

* **Model (`app/src/model`):** Responsável pela manipulação de dados e lógica de negócio. Contém a conexão com o banco de dados (`Conexao.php`) e a representação da entidade (`Usuario.php`).
* **View (`app/src/view`):** A camada de interface. Aqui fica o `dashboardAdmin.php`, que renderiza o layout, gráficos e estatísticas para o usuário final.
* **Controller (`app/src/controller`):** O intermediário. O `UsuarioController.php` processa as requisições (como o login), aciona os Models necessários e define qual View deve ser exibida.



---

## 📁 Estrutura de Pastas Principal

* **`/auth`**: Contém scripts essenciais de segurança, como a verificação de sessão (`VerificarAdmin.php`) e o script de encerramento seguro (`Logout.php`).
* **`/Public`**: Pasta destinada a assets (CSS, JS, Imagens) ou arquivos acessíveis publicamente.
* **`index.php` (Raiz)**: Atua como o **Roteador (Front Controller)** do sistema. Ele interpreta as URLs amigáveis (ex: `/Logout`, `/dashboardAdmin`) e direciona o fluxo para o Controller ou View correspondente.
* **`.htaccess`**: Configurações do servidor Apache para permitir URLs amigáveis, removendo a necessidade de exibir a extensão `.php` na barra de endereços.

---

## 🔐 Sistema de Autenticação e Sessão

O sistema implementa um fluxo de segurança rigoroso para proteger a área administrativa:

1.  **Login**: Ao autenticar com sucesso, os dados do administrador (Nome e Cargo) são armazenados em uma `$_SESSION` protegida no servidor.
2.  **Proteção de Rota**: Todas as páginas administrativas incluem o `VerificarAdmin.php`. Este script valida a sessão ativa; se o usuário não estiver logado, ele é imediatamente expulso para a página inicial.
3.  **Logout Seguro**: Diferente de exclusões simples, o logout realiza uma limpeza profunda: limpa o array de sessão, destrói o cookie no navegador e invalida o cache do browser, impedindo o acesso via botão "voltar".

---

## 📊 Funcionalidades Principais

* **Dashboard Responsivo**: Layout adaptável para dispositivos móveis e desktops com menu lateral retrátil.
* **Gráficos Dinâmicos**: Visualização de dados de vendas e tráfego em tempo real utilizando a biblioteca **Chart.js**.
* **Avatar Inteligente**: Geração automática de avatares com as iniciais do administrador através de integração com API externa.
* **UI Moderna**: Interface limpa utilizando ícones do **Font Awesome** e tipografia **Inter**.

---

## 🛠️ Como Instalar

1.  **Clone o repositório**:
    ```bash
    git clone [https://github.com/seu-usuario/seu-repositorio.git](https://github.com/seu-usuario/seu-repositorio.git)
    ```
2.  **Banco de Dados**: Importe o arquivo SQL localizado em `app/src/config/database.sql` para o seu servidor MySQL.
3.  **Servidor Web**: Certifique-se de que o módulo `mod_rewrite` do Apache está ativado.
4.  **Acesso**: Mova a pasta para o diretório do seu servidor local (ex: `htdocs` no XAMPP ou `www` no WAMP) e acesse via navegador.

---
*Desenvolvido com foco em segurança, modularidade e performance.*