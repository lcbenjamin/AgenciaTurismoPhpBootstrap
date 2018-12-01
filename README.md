# Site Acadêmico de Agência de Turismo

## AgenciaTurismoPhpBootstrap
Site de projeto acadêmico para disciplina CCT0423-TECNOLOGIAS PARA INTERNET II  
Prof. Robson Godoi de Albuquerque Maranhão  
Universidade Estácio de Sá  

## Objetivo

* Criar um site de agência de Turismo com interface publica para visualização e compra de pacotes,
área privada do cliente e área privada do administrador do site

## Ambiente de desenvolvimento
O projeto nesta versão 1.0 foi desenvolvido com o seguinte ambiente:

**S.O**    
* Linux Mint 18.1 Cinnamon 64-bit  

**Servidor LAMPP (Xampp for Linux)**    
* Apache 2.4.34,  
* MariaDB 10.1.36,   
* PHP 7.0.32 + SQLite 2.8.17/3.7.17 + multibyte (mbstring) support  
    
**SGBD**    
* Dbeaver 5.1.3  
* Mysql Workbench 6.3 for Linux  
    
**Editor de Imagens**  
* GIMP 2.8  

**IDE**  
* Visual Studio version 1.29 (VS CODE)  
    
## Tecnologias aplicadas
    
Bootstrap 4.1.3  
Bootstrap DataPicker   
Font Awesome 4.7.0  
Jquery 3.3.1  
Popper.js  
   
## Requisitos


1. A página deve conter um ambiente de controle do acesso.
    1.1 Caso o usuário já tenha cadastro (banco de dados), ele deve informar um login e uma senha      para acessar seu perfil na página.   
    1.2 Caso não tenha cadastro, a página deve apresentar um link para uma página de cadastro do       usuário.  
1. A página deve conter um ambiente de controle do acesso.  
    1.1 Caso o usuário já tenha cadastro (banco de dados), ele deve informar um login e uma senha para acessar seu perfil na página.   
    1.2 Caso não tenha cadastro, a página deve apresentar um link para uma página de cadastro do usuário.  
    1.3 Devem existir dois perfis: Administrador e Cliente.  
    1.4 Deve existir ao menos 01 Administrador e 03 Clientes, previamente cadastrados, no banco       de dados.  
    1.5 As informações de acesso devem ser mantidas em Sessões  
    1.6 Deve existir a opção de desconectar (Logout).  
    
2. O cadastro do usuário deve  
    2.1 Solicitar: Nome completo, Endereço completo, Telefone, E-mail, RG, CPF, Data de nascimento, Foto e Perfil  
    2.2 Os dados devem ser validados  
    2.3 Armazenar em banco de dados.  
    2.4 Criticar o cadastramento de usuário existente.  
    2.5 Tratamentos de erros e avisos  
    2.6 O usuário deve poder alterar seus próprio perfil  

3. O perfil Cliente pode  
    3.1 Comprar: Viagens, agendando data e horário.  
    3.2 Ver: Seu próprio perfil; Viagens disponíveis; Viagens compradas (incluindo os detalhes: passeios, tipo de transporte,   
        valor, etc.); Status das viagens compradas.  
    3.3 Inserir: Perguntas sobre as viagens; Formas de pagamento; Sugestões; etc.    
    3.4 Excluir: Seu próprio perfil; Cancelar uma viagem até 15 dias antes (Lembrar de manter a integridade do banco de dados).  
 
4. O perfil Administrador pode    
    4.1 Ver: Usuários cadastrados; Viagens cadastradas; Mensagens enviadas; Viagens compradas por usuário 
             (incluindo os detalhes: passeios, tipo de transporte, valor, etc.); Status de viagens compradas (efetivada, pendente de   
             confirmação)  
    4.2 Inserir: Novos administradores; Novas viagens.  
    4.3 Excluir: Clientes e Viagens (Lembrar de manter a integridade do banco de dados).  
 
5. Sobre as viagens   
    5.1 Devem haver ao menos 7 viagens cadastradas.  
    5.2 Deve conter: Fotos, roteiro de passeios, pacotes e preços.  
    5.3 Os preços variam de acordo com: A viagem, os dias de permanência, o tipo de transporte, os pacotes, etc (os valores devem vir  
        do banco de dados. Nada hardcode ou percentual).  

6. Sobre os cadastros  
    6.1 Todos os cadastros devem ser feitos via interface HTML com script PHP utilizando comandos SQL (select, insert, update e delete). 
    6.2 Devem permitir a Inclusão, Alteração e Exclusão dos dados.  
    6.3 O login e a senha segue o mesmo requisito dos cadastros, utilizando o comando SQL (select) e garantindo a criptografia da   
        senha de qualquer usuário.
 
7. No site deve existir: 
    7.1 Uma página inicial completa e organizada, com diversas fotos e informações sobre a agencia de turismo  
    7.2 A visualização de várias fotos com legendas sobre as viagens existentes.  
    7.3 A possibilidade de escolha de viagens (a partir das fotos) e da compra, indicando: datas, tipo de transporte, tipo de   
        hospedagem, passeios, etc  
    7.4 Páginas para cadastros de usuários e viagens.  

8. Geral  
    8.1 Todas as inserções, exclusões ou seleções devem ser feitas seguindo o mesmo critério  
    8.2 Cada trecho de código deve ser devidamente comentada e explicada  
    8.3 Utilizem HTML, CSS e Javascript (opcionais).   
    8.4 Utilizem MYSQL e PHP (obrigatórios).   
    
9. Avaliação  
    9.1 Site rodando e funcional.  
    9.2 Código comentado e compreensível.  
    9.3 Responder as perguntas.  

