import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router, usePage } from "@inertiajs/react";
import { useState, useEffect } from "react";
import { useFormik } from "formik";
import * as yup from "yup";
import React from "react";
import { useAppToast } from "@/utils/toast.util";

// Chakra imports
import {
    FormControl,
    FormErrorMessage,
    FormLabel,
    Input,
    Text,
    Flex,
    Img,
    Box,
    Button,
} from "@chakra-ui/react";
import { AiFillSave, AiOutlinePlus } from "react-icons/ai";
// Custom components

export default function Form({ auth, employee, companies }) {
    const [employeeData, setEmployeesData] = useState(employee ?? {});
    const [companiesData, setcompaniesData] = useState(companies ?? []);

    const { errors } = usePage().props;
    const { showToast } = useAppToast();

    const formikEmployee = useFormik({
        initialValues: {
            first_name: employee?.first_name ?? "",
            last_name: employee?.last_name ?? "",
            email: employee?.email ?? "",
            phone_number: employee?.phone_number ?? "",
            company_id: employee?.company_id ?? "",
        },

        validationSchema: yup.object().shape({
            first_name: yup.string().required("Name is required"),
            last_name: yup.string().required("Name is required"),
            email: yup.string().required("Name is required"),
            phone_number: yup.string().required("Name is required"),
            company_id: yup.string().required("Name is required"),
        }),

        onSubmit: (values) => {
            try {
                !employee
                    ? router.post("/api/employee/store", values)
                    : router.post(
                          "/api/employee/update/" + employee.id,
                          values
                      );

                showToast({
                    title: "Success",
                    description: employee ? "Updated!" : "Created",
                    status: "success",
                });
            } catch (error) {
                throw error;
            }
        },
    });

console.log(formikEmployee.values)



    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Employee Form
                </h2>
            }
        >
            <Head title="Employee Form" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Flex
                            zIndex="2"
                            direction="column"
                            w={{ base: "100%", md: "420px" }}
                            maxW="100%"
                            background="transparent"
                            borderRadius="15px"
                            mx={{ base: "auto", lg: "unset" }}
                            me="auto"
                            mb={{ base: "20px", md: "auto" }}
                            p={"5"}
                        >
                            <InputWithLabel
                                formik={formikEmployee}
                                label={"First Name"}
                                field={"first_name"}
                                placeholder={"Insert first name"}
                            />
                            <InputWithLabel
                                formik={formikEmployee}
                                label={"Last Name"}
                                field={"last_name"}
                                placeholder={"Insert last name"}
                            />
                            <InputWithLabel
                                formik={formikEmployee}
                                label={"Email"}
                                field={"email"}
                                placeholder={"Insert email"}
                            />
                            <InputWithLabel
                                formik={formikEmployee}
                                label={"Phone Number"}
                                field={"phone_number"}
                                placeholder={"Insert phone number"}
                            />
                            <FormControl
                                isInvalid={
                                    !!(
                                        formikEmployee.errors["company_id"] &&
                                        formikEmployee.touched["company_id"]
                                    )
                                }
                                my={"1"}
                            >
                                <FormLabel
                                    display="flex"
                                    ms="4px"
                                    fontSize="sm"
                                    fontWeight="500"
                                    mb="8px"
                                >
                                    Company
                                </FormLabel>
                                <select
                                    onChange={(e) => {
                                        formikEmployee.setFieldValue(
                                            "company_id",
                                            e.target.value
                                        );
                                    }}

                                    defaultValue={employee.company_id}
                                >
                                    <option>Select company</option>
                                    {companies &&
                                        companies.map((company) => {
                                            return (
                                                <option
                                                    key={company.id}
                                                    value={company.id}
                                                    // selected={employee.company_id == company.id}
                                                >
                                                    {company.name}
                                                </option>
                                            );
                                        })}
                                </select>
                                <FormErrorMessage fontSize={"xs"}>
                                    {formikEmployee.errors["company_id"]}
                                </FormErrorMessage>
                            </FormControl>
                            <Button
                                p={"2"}
                                colorScheme={"blue"}
                                onClick={() => {
                                    formikEmployee.submitForm();
                                }}
                            >
                                {employee ? (
                                    <AiFillSave style={{ marginRight: "10" }} />
                                ) : (
                                    <AiOutlinePlus
                                        style={{ marginRight: "10" }}
                                    />
                                )}{" "}
                                Employee
                            </Button>
                        </Flex>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

export const InputWithLabel = ({
    label,
    formik,
    field,
    // type,
    placeholder = "type here",
    isRequired = false,
    maxLength = 50,
}) => {
    return (
        <FormControl
            isInvalid={!!(formik.errors[field] && formik.touched[field])}
            my={"1"}
        >
            <FormLabel
                display="flex"
                ms="4px"
                fontSize="sm"
                fontWeight="500"
                mb="8px"
            >
                {label} {isRequired && <Text mx={"1"}>*</Text>}
            </FormLabel>
            <Input
                isRequired={isRequired}
                variant="auth"
                fontSize="sm"
                ms={{ base: "0px", md: "0px" }}
                // type={type}
                placeholder={placeholder}
                fontWeight="500"
                size="lg"
                {...formik.getFieldProps(field)}
                maxLength={maxLength}
            />
            <FormErrorMessage fontSize={"xs"}>
                {formik.errors[field]}
            </FormErrorMessage>
        </FormControl>
    );
};
