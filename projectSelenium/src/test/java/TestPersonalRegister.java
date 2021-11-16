
import static org.junit.jupiter.api.Assertions.*;

import java.awt.TextComponent;
import java.util.Random;
import java.util.concurrent.TimeUnit;

import org.junit.Before;
import org.junit.jupiter.api.*;
import org.junit.jupiter.api.MethodOrderer.OrderAnnotation;
import org.junit.jupiter.api.TestInstance.Lifecycle;
import org.openqa.selenium.By;
import org.openqa.selenium.By.ByXPath;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.WebDriverWait;
import org.w3c.dom.Text;

import com.inflectra.spiratest.addons.junitextension.SpiraTestCase;
import com.inflectra.spiratest.addons.junitextension.SpiraTestConfiguration;

/**
 * 
 * @author Fengning Tian
 * @version 1.0
 *
 * 
 */


@TestMethodOrder(OrderAnnotation.class) // << this annotation is for using @order, or adding order to my test-cases
public class TestPersonalRegister {
	// define all your variables that you need to initialise through different tests
	private static ChromeDriver driver;
	private String expectedResult;
	private String actualResult;
	private WebElement element;
	private WebDriverWait wait = new WebDriverWait(driver, 10);
    private static String randomEmail;
    private static String randomName;
	

	@BeforeAll
	// setup my driver here through @BeforeAll, this method is running once before
	// all test-cases
	public static void setup() {
		
		// chromedriver must be replaced if it is not working or your operating system is not windows
		
		System.setProperty("Webdriver.chrome.driver", "chromedriver.exec");
		

		driver = new ChromeDriver();
		
		String str="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		StringBuilder sb=new StringBuilder(6);
		for(int i=0;i<6;i++)
		{
		char randomNumber = str.charAt(new Random().nextInt(str.length()));
		sb.append(randomNumber);
		}
		randomName = sb.toString();

	    randomEmail = randomName + "@" + "test.com";

	}

	@Test
	@Order(1) // << the order of the test, so this test-case is running as first
	// Test if the browser is openning the page
	public void websiteTest() {

		driver.get("http://localhost/billingplusu/BillingPlusU/public/login");

		// Specifies the amount of time the driver should wait when searching
		// for an element if it is not immediately present. ( same as thread sleep but
		// in the right way)
		driver.manage().timeouts().implicitlyWait(5, TimeUnit.SECONDS); // << I asked wait maximum for 5 seconds for the next
		/*
		 * Another wait method:
		 * Sets the amount of time to wait for a page load to 
		 * complete before throwing an error.If the timeout is 
		 * negative, page loads can be indefinite.
		 * driver.manage().timeouts().pageLoadTimeout(time, unit)																// element
		 */

		expectedResult = "BillingPlusU";
		actualResult = driver.getTitle();
		assertEquals(expectedResult, actualResult);

	}

	@Test
	@Order(2) // << the order of the test, so this test-case is running as 2nd
	public void createButttonTest() {
		//test create an account button 
		driver.findElement(By.xpath("/html/body/div/div/div[3]/div[1]/a")).click();
		expectedResult = "Package Selection";
		actualResult = driver.getTitle();
		assertEquals(expectedResult, actualResult);
	}

	@Test
	@Order(3) // << the order of the test, so this test-case is running as 3rd
	public void personalStartButtonTest() {
		//test personal account start button 
		driver.findElement(By.xpath("/html/body/div/div/div/div[2]/div/div[3]/a")).click();
		expectedResult = "Register";
		actualResult = driver.getTitle();
		assertEquals(expectedResult, actualResult);
	}

	@Test
	@Order(4) // << the order of the test, so this test-case is running as 4th
	public void invalidFnTest() {
		//test invalid first name 
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/div[1]/div/input")).sendKeys("123");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/div[2]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).sendKeys(randomEmail);
		driver.findElement(By.xpath("//*[@id=\"password\"]")).sendKeys("123456Abc");
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).sendKeys("123456Abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/div[6]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/div[7]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("//*[@id=\"input-select\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"input-select\"]/option[4]")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/label")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[3]/button")).click();
		expectedResult = "The first name may only contain letters.";
		actualResult = driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/ul/li")).getText();
		assertEquals(expectedResult, actualResult);
	}
	

	@Test
	@Order(5) // << the order of the test, so this test-case is running as 5th
	public void invalidLnTest() {
		//test invalid last name 
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).clear();
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).clear();		
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).sendKeys("123");
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).sendKeys(randomEmail);
		driver.findElement(By.xpath("//*[@id=\"password\"]")).sendKeys("123456Abc");
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).sendKeys("123456Abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("//*[@id=\"input-select\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"input-select\"]/option[4]")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[3]/label")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[4]/button")).click();
		expectedResult = "The last name may only contain letters.";
		actualResult = driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/ul/li")).getText();
		assertEquals(expectedResult, actualResult);
	}
	

	@Test
	@Order(6) // << the order of the test, so this test-case is running as 6th
	public void invalidEmailTest() {
		//test invalid Email address
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).clear();
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).clear();		
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).sendKeys("123");
		driver.findElement(By.xpath("//*[@id=\"password\"]")).sendKeys("123456Abc");
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).sendKeys("123456Abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("//*[@id=\"input-select\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"input-select\"]/option[4]")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[3]/label")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[4]/button")).click();
		expectedResult = "The email must be a valid email address.";
		actualResult = driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/ul/li")).getText();
		assertEquals(expectedResult, actualResult);
	}
	


	@Test
	@Order(7) // << the order of the test, so this test-case is running as 7th
	public void registeredEmailTest() {
		//test registered Email address
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).clear();
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).clear();		
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).sendKeys("finnick9387@gmail.com");
		driver.findElement(By.xpath("//*[@id=\"password\"]")).sendKeys("123456Abc");
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).sendKeys("123456Abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("//*[@id=\"input-select\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"input-select\"]/option[4]")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[3]/label")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[4]/button")).click();
		expectedResult = "The email has already been taken.";
		actualResult = driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/ul/li")).getText();
		assertEquals(expectedResult, actualResult);
	}
	
	@Test
	@Order(8) // << the order of the test, so this test-case is running as 8th
	public void invalidPwdTest1() {
		//test invalid password less than 8 characters
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).clear();
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).clear();		
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).sendKeys(randomEmail);
		driver.findElement(By.xpath("//*[@id=\"password\"]")).sendKeys("123456");
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).sendKeys("123456");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("//*[@id=\"input-select\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"input-select\"]/option[4]")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[3]/label")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[4]/button")).click();
		expectedResult = "The password must be at least 8 characters.";
		actualResult = driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/ul/li")).getText();
		assertEquals(expectedResult, actualResult);
	}
	
	

	@Test
	@Order(9) // << the order of the test, so this test-case is running as 9th
	public void invalidPwdTest2() {
		//test invalid password without upper case letter
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).clear();
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).clear();		
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).sendKeys(randomEmail);
		driver.findElement(By.xpath("//*[@id=\"password\"]")).sendKeys("123456abc");
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).sendKeys("123456abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("//*[@id=\"input-select\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"input-select\"]/option[4]")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[3]/label")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[4]/button")).click();
		expectedResult = "The password format is invalid.";
		actualResult = driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/ul/li")).getText();
		assertEquals(expectedResult, actualResult);
	}
	
	

	@Test
	@Order(10) // << the order of the test, so this test-case is running as 10th
	public void invalidPwdTest3() {
		//test invalid password without lower case letter
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).clear();
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).clear();		
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).sendKeys(randomEmail);
		driver.findElement(By.xpath("//*[@id=\"password\"]")).sendKeys("123456ABC");
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).sendKeys("123456ABC");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("//*[@id=\"input-select\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"input-select\"]/option[4]")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[3]/label")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[4]/button")).click();
		expectedResult = "The password format is invalid.";
		actualResult = driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/ul/li")).getText();
		assertEquals(expectedResult, actualResult);
	}
	


	@Test
	@Order(11) // << the order of the test, so this test-case is running as 11th
	public void invalidPwdTest4() {
		//test invalid password without number
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).clear();
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).clear();		
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).sendKeys(randomEmail);
		driver.findElement(By.xpath("//*[@id=\"password\"]")).sendKeys("abcabcABC");
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).sendKeys("abcabcABC");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("//*[@id=\"input-select\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"input-select\"]/option[4]")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[3]/label")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[4]/button")).click();
		expectedResult = "The password format is invalid.";
		actualResult = driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/ul/li")).getText();
		assertEquals(expectedResult, actualResult);
	}
	

	@Test
	@Order(12) // << the order of the test, so this test-case is running as 12th
	public void invalidRePwdTest() {
		//test invalid retype password
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).clear();
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).clear();		
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).sendKeys(randomEmail);
		driver.findElement(By.xpath("//*[@id=\"password\"]")).sendKeys("abcabcABC123");
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).sendKeys("abcabcABC");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("//*[@id=\"input-select\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"input-select\"]/option[4]")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[3]/label")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[4]/button")).click();
		expectedResult = "The password confirmation does not match.";
		actualResult = driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/ul/li")).getText();
		assertEquals(expectedResult, actualResult);
	}
	
	

	@Test
	@Order(13) // << the order of the test, so this test-case is running as 13th
	public void invalidMobileTest() {
		//test invalid mobile number
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).clear();
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).clear();		
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).sendKeys(randomEmail);
		driver.findElement(By.xpath("//*[@id=\"password\"]")).sendKeys("abcabcABC123");
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).sendKeys("abcabcABC123");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("//*[@id=\"input-select\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"input-select\"]/option[4]")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[3]/label")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[4]/button")).click();
		expectedResult = "The mobile number must be between 1 and 50 digits.";
		actualResult = driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/ul/li")).getText();
		assertEquals(expectedResult, actualResult);
	}
	


	

	@Test
	@Order(14) // << the order of the test, so this test-case is running as 14th
	public void invalidPostTest() {
		//test invalid post code
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).clear();
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).clear();		
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).sendKeys(randomEmail);
		driver.findElement(By.xpath("//*[@id=\"password\"]")).sendKeys("abcabcABC123");
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).sendKeys("abcabcABC123");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("//*[@id=\"input-select\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"input-select\"]/option[4]")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[3]/label")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[4]/button")).click();
		expectedResult = "The post code must be a number.";
		actualResult = driver.findElement(By.xpath("/html/body/form/div/div[2]/div[1]/ul/li")).getText();
		assertEquals(expectedResult, actualResult);
	}
	



	@Test
	@Order(15) // << the order of the test, so this test-case is running as 15th
	public void validInputTest() {
		//test valid input to register 

		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).clear();
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password\"]")).clear();
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).clear();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).clear();		
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[1]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[2]/div/input")).sendKeys("abc");
		driver.findElement(By.xpath("//*[@id=\"validationCustom03\"]")).sendKeys(randomEmail);
		driver.findElement(By.xpath("//*[@id=\"password\"]")).sendKeys("123456Abc");
		driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]")).sendKeys("123456Abc");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[6]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[2]/div[7]/div/input")).sendKeys("12345678");
		driver.findElement(By.xpath("//*[@id=\"input-select\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"input-select\"]/option[4]")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[3]/label")).click();
		driver.findElement(By.xpath("/html/body/form/div/div[2]/div[4]/button")).click();
		expectedResult = "Login";
		actualResult = driver.getTitle();
		assertEquals(expectedResult, actualResult);
	}
	

	
	@AfterAll
	// closing or quitting the browser after the test
	public static void closeBrowser() {
		driver.close();
		// driver.quit();
	}
}
