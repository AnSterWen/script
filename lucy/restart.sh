#!/bin/bash
./Sea_Stop >/dev/null 2>&1 && echo "stop OK" || echo "stop FAILED"
./Sea_Startup >/dev/null 2>&1 && echo "restart OK" || echo "restart FAILED"

