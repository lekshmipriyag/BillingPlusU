
import static org.junit.jupiter.api.Assertions.*;

import java.awt.TextComponent;
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
public class TestForgotPwd {

	private static ChromeDriver driver;
	private String expectedResult;
	private String actualResult;
	private WebElement element;
	private WebDriverWait wait = new WebDriverWait(driver, 10);;
	

	@BeforeAll
	// setup my driver here through @BeforeAll, this method is running once before
	// all test-cases
	public static void setup() {
		
		// chromedriver must be replaced if it is not working or your operating system is not windows
		
		System.setProperty("Webdriver.chrome.driver", "chromedriver.exec");
		

		driver = new ChromeDriver();

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

		expectedResult = "Login";
		actualResult = driver.getTitle();
		assertEquals(expectedResult, actualResult);

	}

	@Test
	@Order(2) // << the order of the test, so this test-case is running as 2nd
	public void forgotButtonTest() {
		//test forgot password button 
		driver.findElement(By.xpath("/html/body/div/div/div[3]/div[2]")).click();
		expectedResult = "Forgot Password";
		actualResult = driver.getTitle();
		assertEquals(expectedResult, actualResult);
	}

	@Test
	@Order(3) // << the order of the test, so this test-case is running as 3rd
	public void unregisteredEmailTest() {
		//test input unregistered email address
		driver.findElement(By.xpath("/html/body/div/div/div[2]/form/div[1]/input")).sendKeys("finnick387@gmail.com");
		driver.findElement(By.xpath("/html/body/div/div/div[2]/form/div[2]/button")).click();
		expectedResult = "Email does not exist!";
		actualResult = driver.findElement(By.xpath("/html/body/div/div/div[2]/div/strong")).getText();
		assertEquals(expectedResult, actualResult);
	}


	@Test
	@Order(4) // << the order of the test, so this test-case is running as 3rd
	public void validEmailTest() {
		//test input valid email address
		driver.findElement(By.xpath("/html/body/div/div/div[2]/form/div[1]/input")).sendKeys("finnick9387@gmail.com");
		driver.findElement(By.xpath("/html/body/div/div/div[2]/form/div[2]/button")).click();
		expectedResult = "A reset link has been sent to your email address.";
		actualResult = driver.findElement(By.xpath("/html/body/div/div/div[2]/div")).getText();
		assertEquals(expectedResult, actualResult);
	}

	
	@AfterAll
	// closing or quitting the browser after the test
	public static void closeBrowser() {
		driver.close();
		// driver.quit();
	}
}
