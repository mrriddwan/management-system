import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router } from "@inertiajs/react";
import { useState, useEffect } from "react";
import { useFormik } from "formik";
import * as yup from "yup";
import React from "react";
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
import { AiOutlinePlus } from "react-icons/ai";
// Custom components

export default function Form({ auth, company }) {
    const [companyData, setCompanyData] = useState(company ?? {});

    const formikCompany = useFormik({
        initialValues: {
            name: company?.name ?? "",
            email: company?.email ?? "",
            logo: company?.logo ?? {},
            website_url: company?.website_url ?? "",
        },

        validationSchema: yup.object().shape({
            name: yup.string().required("Name is required"),
            email: yup.string().required("Email is required"),
            // logo: yup.string().required("Logo is required"),
            website_url: yup.string().required("Website url is required"),
        }),

        onSubmit: (values) => {
            values.logo = values?.logo?.file ?? null;

            router.post("/api/company/store", values);
        },
    });

    useEffect(() => {}, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Company Form
                </h2>
            }
        >
            <Head title="Company Form" />

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
                                formik={formikCompany}
                                label={"Name"}
                                field={"name"}
                                placeholder={"Insert name of company"}
                            />
                            <InputWithLabel
                                formik={formikCompany}
                                label={"Email"}
                                field={"email"}
                                placeholder={"Insert email of company"}
                            />
                            <InputWithLabel
                                formik={formikCompany}
                                label={"Website URL"}
                                field={"website_url"}
                                placeholder={"Insert website of company"}
                            />
                            {/* <InputWithLabel
                                formik={formikCompany}
                                label={"Logo"}
                                field={"logo"}
                                placeholder={"Insert name of company"}
                            /> */}
                            <InputFile
                                formik={formikCompany}
                                field={"logo"}
                                label={"Logo"}
                            />
                            <Box w={"full"}>
                                <Img
                                    src={formikCompany.values.logo.fileUrl}
                                    mx={"auto"}
                                    py={"5"}
                                />
                            </Box>
                            <Button
                                p={"2"}
                                colorScheme={"blue"}
                                onClick={() => {
                                    formikCompany.submitForm();
                                }}
                            >
                                <AiOutlinePlus /> Company
                            </Button>
                        </Flex>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

export const InputFile = ({ formik, label, field }) => {
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
                {label}
            </FormLabel>
            <Input
                name="image"
                id="image"
                variant={"outline"}
                type={"file"}
                // hidden
                accept="image/jpeg,image/png"
                onChange={(e) => {
                    let tempFile = {};

                    const isLessThan2MB = (val) => {
                        return val / (1024 * 1024) < 2;
                    };

                    const pushTemp = (val) => {
                        if (
                            val.type !== "image/jpeg" &&
                            val.type !== "image/png"
                        ) {
                            showToast({
                                title: "Invalid File Type",
                                description:
                                    "Please choose a PDF, JPEG or PNG type file",
                                status: "error",
                            });
                        } else if (!isLessThan2MB(val.size)) {
                            showToast({
                                title: "File size more than 2MB!",
                                description: "Please choose a lower size file",
                                status: "error",
                            });
                        } else {
                            tempFile = {
                                file: val,
                                fileUrl: URL.createObjectURL(val),
                                istouched: true,
                                isValid: true,
                            };
                        }
                    };

                    let value = e.target.files[0];

                    if (value) {
                        pushTemp(value);
                    }

                    console.log(tempFile);

                    // console.log(temp);
                    formik.setFieldValue(field, tempFile);
                }}
            />
            <FormErrorMessage fontSize={"xs"}>
                {formik.errors[field]}
            </FormErrorMessage>
        </FormControl>
    );
};

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
