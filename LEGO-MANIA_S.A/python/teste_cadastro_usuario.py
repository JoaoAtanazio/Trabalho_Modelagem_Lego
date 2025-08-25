from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
import time

# Configuração do WebDriver (nesse exemplo, estamos usando o Chrome)
driver = webdriver.Chrome ()

# Acessa a página de cadastro usando o caminho absoluto com o protocolo file://
# Ceritifuqe-se de que o caminho está apontando par aum arquivo HTML específico

driver.get('http://localhost:8080/trabalho_modelagem_lego/LEGO-MANIA_S.A/index.php')
#Preenche o campo Nome

email_input_login = driver.find_element(By.ID, "email")
email_input_login.send_keys("admin@admin")
time.sleep(1)

senha_input = driver.find_element(By. ID, "senha")
senha_input.send_keys("123")
time.sleep(1)

login_button = driver.find_element(By. ID, "entrar_button")
login_button.click()
time.sleep(1)

cadastro_button = driver.find_element(By. ID, "cadastroDropdown")
cadastro_button.click()
time.sleep(1)

usuario_button = driver.find_element(By. ID, "cadastro_usuario")
usuario_button.click()
time.sleep(1)

nome_input = driver.find_element(By. ID, "nome_usuario")
nome_input.send_keys ("Atanazio")
time.sleep(1)

perfil_input = driver.find_element(By.ID, "id_perfil")
perfil_input.click()
time.sleep(1)

select = driver.find_element(By. ID, "tecoption")
select.click()
time.sleep(1)

email_input = driver.find_element(By.ID, "email")
email_input.send_keys("Atanazio@gmail.com")
time.sleep(1)

senha_input = driver.find_element(By. ID, "senha")
senha_input.send_keys("12345678")

#Clica no botão de Cadastrar

submit_button = driver.find_element(By. ID, "botaocadastro")
submit_button.click()




