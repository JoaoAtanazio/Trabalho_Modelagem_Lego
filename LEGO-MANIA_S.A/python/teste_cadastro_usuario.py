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

email_input_input = driver.find_element(By.ID, "email")
email_input_input.send_keys("admin@admin")
time.sleep(2)

senha_input = driver.find_element(By. ID, "senha")
senha_input.send_keys("123")
time.sleep(2)

submit_button = driver.find_element(By. ID, "entrar_button")
submit_button.click()
time.sleep(2)

cadastro_button = driver.find_element(By. ID, "cadastroDropdown")
cadastro_button.click()
time.sleep(2)

perfil_input = driver.find_element(By.ID, "id_perfil")

select = Select(perfil_input)

select.select_by_visible_text("Técnico")

select.select_by_value("4")

select.select_by_index(3)

email_input = driver.find_element(By.ID, "email")
email_input.send_keys("JoaoSilva@gmail.com")

senha_input = driver.find_element(By. ID, "senha")
email_input.send_keys("12345678")
#Clica no botão de Cadastrar
#submit_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit]")
#submit_button.click()




