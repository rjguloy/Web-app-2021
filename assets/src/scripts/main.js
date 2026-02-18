import $ from "jquery";
import "bootstrap";
import "slick-carousel";
import "flatpickr";
import "chart.js";
// import canvasjs from 'canvasjs';

require("datatables.net")(window, $);
require("datatables.net-bs4")($);

window.$ = window.jQuery = $;

$(document).ready(function () {
	// Slick Slider - Login
	$(".login-slider").slick({
		dots: true,
		infinite: true,
		speed: 500,
		fade: true,
		cssEase: "linear",
		autoplay: true,
		autoplaySpeed: 1700,
	});
	// Slick Slider - Home
	$(".home-slider").slick({
		dots: true,
		infinite: true,
		speed: 500,
		fade: true,
		cssEase: "linear",
		autoplay: true,
		autoplaySpeed: 1700,
	});
	$("#hamburger").click(function () {
		$(this).toggleClass("open");
	});
	// Dropdown Menu
	$(".sub-menu ul").hide();
	$(".sub-menu a").click(function () {
		$(this).parent(".sub-menu").children("ul").slideToggle("100");
		// $(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
	});

	$(function () {
		$(".sidebar-nav > li ul > li a"),
			$(".sidebar-nav > li a")
				.filter(function () {
					return this.href == location.href;
				})
				.addClass("selected")
				.siblings()
				.removeClass("selected");
		$("#sidebar-menu li a").click(function () {
			$(this)
				.parent()
				.addClass("activeSidebar")
				.siblings()
				.removeClass("activeSidebar");
		});
	});
	// menu toggle state
	$(".menu-toggle").on("click", function (e) {
		localStorage.setItem("menu-closed", !$("#wrapper").hasClass("toggled"));
		$("#wrapper").toggleClass("toggled");
		$(".sidebar-wrapper").addClass("transitioning");
	});
	var state = localStorage.getItem("menu-closed");

	if (state === "true") {
		$("#wrapper").addClass("toggled");
	} else {
		$("#wrapper").removeClass("toggled");
	}

	// *****************************************************************************
	// Collapse Accordion

	$(".card .collapse").on("shown.bs.collapse", function () {
		var active = $(this).attr("id");
		var accordionPanel =
			localStorage.accordionPanel === undefined
				? new Array()
				: JSON.parse(localStorage.accordionPanel);
		if ($.inArray(active, accordionPanel) == -1) accordionPanel.push(active);
		localStorage.accordionPanel = JSON.stringify(accordionPanel);
	});

	$(".card .collapse").on("hidden.bs.collapse", function () {
		var active = $(this).attr("id");
		var accordionPanel =
			localStorage.accordionPanel === undefined
				? new Array()
				: JSON.parse(localStorage.accordionPanel);
		var elementIndex = $.inArray(active, accordionPanel);
		if (elementIndex !== -1) {
			accordionPanel.splice(elementIndex, 1);
		}
		localStorage.accordionPanel = JSON.stringify(accordionPanel);
	});

	var accordionPanel =
		localStorage.accordionPanel === undefined
			? new Array()
			: JSON.parse(localStorage.accordionPanel);
	for (var i in accordionPanel) {
		if ($("#" + accordionPanel[i]).hasClass("collapse")) {
			$("#" + accordionPanel[i]).collapse("show");
		}
	}
	// *****************************************************************************

	// Flatpickr
	flatpickr(".flatpickr", {
		mode: "range",
		minDate: "today",
		dateFormat: "Y-m-d",
		disable: [
			function (date) {
				// disable every multiple of 8
				// return !(date.getDate() % 8);
			},
		],
	});
	// Modal on page load
	$(window).on("load", function () {
		$("#reportsDate").modal("show");
	});
	// Gallery
	let overlay = document.querySelector(".overlayContainer"),
		largeImage = document.querySelector(".largeImage");

	const hideOverlay = () => {
		overlay.removeEventListener("click", hideOverlay, false);
		overlay.classList.remove("opacity");

		setTimeout(function () {
			largeImage.removeAttribute("src");
			largeImage.removeAttribute("alt");
			overlay.classList.remove("display");
		}, 400);
	};

	function lightbox(event) {
		const caption = document.querySelector(".imageCaption");
		let href, alt;

		event.preventDefault();
		href = this.getAttribute("href");
		alt = this.children[0].getAttribute("alt");

		largeImage.setAttribute("src", href);
		largeImage.setAttribute("alt", alt);
		caption.innerHTML = alt;
		overlay.classList.add("display");

		setTimeout(function () {
			overlay.classList.add("opacity");
		}, 25);
		setTimeout(function () {
			overlay.addEventListener("click", hideOverlay, false);
		}, 400);
	}

	/***Event Listener***/
	const runCode = () => {
		const image = document.querySelectorAll(".imageLink");
		if (image) {
			for (var i = 0; i < image.length; i++) {
				image[i].addEventListener("click", lightbox, false);
			}
		}
	};
	runCode();

	// Change Password
	$("#cpword-link").click(function (e) {
		clearForm();
		clearMessages();
	});

	$("#cpword-save-btn").click(function (e) {
		e.preventDefault();

		var oldpword = $.trim($("#cpword-oldpword").val());
		var newpword = $.trim($("#cpword-npword").val());
		var cnewpword = $.trim($("#cpword-re-npword").val());
		var err = 0;

		clearMessages();

		if (oldpword == "") {
			err = 1;
			$("#oldpword-error-msg-div").addClass("d-block");
		}

		if (newpword == "") {
			err = 1;
			$("#npword-error-msg-div").addClass("d-block");
		}

		if (cnewpword == "") {
			err = 1;
			$("#re-npword-error-msg").html("Required.");
			$("#re-npword-error-msg-div").addClass("d-block");
		}

		if (newpword != "" && cnewpword != "" && newpword != cnewpword) {
			err = 1;
			$("#re-npword-error-msg").html(
				"New password and confirm password does not match."
			);
			$("#re-npword-error-msg-div").addClass("d-block");
		}

		if (err == 0) {
			$.ajax({
				type: "POST",
				url: "password/change",
				data: { oldpword: oldpword, newpword: newpword },
				dataType: "json",
				success: function (data) {
					$("#error-msg-div").addClass("success-msg d-block");
					$("#error-msg").html("Change password successful.");
					clearForm();
					// setTimeout(
					// 	function(){
					// 		$('#modalChangePassword').modal('toggle');
					// 	},
					// 	1500
					// );
				},
				error: function (data) {
					$("#error-msg-div").addClass("error-msg d-block");
					$("#error-msg").html(data.responseText);
				},
			});
		}
	});

	function clearForm() {
		$("#cpword-oldpword").val("");
		$("#cpword-npword").val("");
		$("#cpword-re-npword").val("");
	}

	function clearMessages() {
		$("#oldpword-error-msg-div").removeClass("d-block");
		$("#npword-error-msg-div").removeClass("d-block");
		$("#re-npword-error-msg-div").removeClass("d-block");
		$("#error-msg-div").removeClass("success-msg error-msg d-block");
		$("#error-msg").html("");
	}
});
